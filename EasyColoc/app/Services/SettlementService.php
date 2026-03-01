<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class SettlementService
{
    /**
     * @return array<int, array{user: User, paid_cents: int, share_cents: int, balance_cents: int}>
     */
    public function balances(Collection $members, Collection $expenses, Collection $payments): array
    {
        $memberIds = $members->pluck('id')->values();

        $paidByUser = [];
        foreach ($memberIds as $id) {
            $paidByUser[$id] = 0;
        }

        $totalExpenseCents = 0;
        foreach ($expenses as $expense) {
            $amount = $this->toCents($expense->amount);
            $totalExpenseCents += $amount;

            $payerId = (int) $expense->paid_by_user_id;
            if (array_key_exists($payerId, $paidByUser)) {
                $paidByUser[$payerId] += $amount;
            }
        }

        $memberCount = max(1, (int) $memberIds->count());
        $shareCents = (int) intdiv($totalExpenseCents, $memberCount);

        $balances = [];
        foreach ($members as $member) {
            $paidCents = $paidByUser[$member->id] ?? 0;
            $balances[$member->id] = [
                'user' => $member,
                'paid_cents' => $paidCents,
                'share_cents' => $shareCents,
                'balance_cents' => $paidCents - $shareCents,
            ];
        }

        foreach ($payments as $payment) {
            $amount = $this->toCents($payment->amount);

            $fromId = (int) $payment->from_user_id;
            $toId = (int) $payment->to_user_id;

            if (isset($balances[$fromId])) {
                $balances[$fromId]['balance_cents'] += $amount;
            }

            if (isset($balances[$toId])) {
                $balances[$toId]['balance_cents'] -= $amount;
            }
        }

        return $balances;
    }

    /**
     * @param array<int, array{user: User, paid_cents: int, share_cents: int, balance_cents: int}> $balances
     * @return array<int, array{from: User, to: User, amount_cents: int}>
     */
    public function settlements(array $balances): array
    {
        $creditors = [];
        $debtors = [];

        foreach ($balances as $row) {
            if ($row['balance_cents'] > 0) {
                $creditors[] = ['user' => $row['user'], 'amount' => $row['balance_cents']];
            } elseif ($row['balance_cents'] < 0) {
                $debtors[] = ['user' => $row['user'], 'amount' => -$row['balance_cents']];
            }
        }

        $i = 0;
        $j = 0;
        $settlements = [];

        while ($i < count($debtors) && $j < count($creditors)) {
            $pay = min($debtors[$i]['amount'], $creditors[$j]['amount']);

            if ($pay > 0) {
                $settlements[] = [
                    'from' => $debtors[$i]['user'],
                    'to' => $creditors[$j]['user'],
                    'amount_cents' => $pay,
                ];
            }

            $debtors[$i]['amount'] -= $pay;
            $creditors[$j]['amount'] -= $pay;

            if ($debtors[$i]['amount'] === 0) {
                $i++;
            }
            if ($creditors[$j]['amount'] === 0) {
                $j++;
            }
        }

        return $settlements;
    }

    public function formatCents(int $cents): string
    {
        return number_format($cents / 100, 2, '.', '');
    }

    private function toCents(mixed $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }
}

