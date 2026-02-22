<template>
  <AppLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold">Таърихи транзаксияҳо</h1>
          <p class="text-surface-400 mt-1">Журнали аудитии ҳамаи пардохтҳои коркардшуда.</p>
        </div>
      </div>

      <!-- Transactions List -->
      <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="text-surface-500 text-sm uppercase tracking-wider">
                <th class="px-6 py-4 font-semibold">Истифодабаранда</th>
                <th class="px-6 py-4 font-semibold text-right">Баланси аввалия</th>
                <th class="px-6 py-4 font-semibold text-right">Маблағ</th>
                <th class="px-6 py-4 font-semibold text-right text-amber-400">Комиссия</th>
                <th class="px-6 py-4 font-semibold text-right text-brand-400">Ҷамъ</th>
                <th class="px-6 py-4 font-semibold text-right">Баланси ниҳоӣ</th>
                <th class="px-6 py-4 font-semibold text-center">Статус</th>
                <th class="px-6 py-4 font-semibold">Рамз</th>
                <th class="px-6 py-4 font-semibold">Сана</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
              <tr v-for="tx in transactions" :key="tx.id" class="hover:bg-white/5 transition-all">
                <td class="px-6 py-4">
                  <div class="font-medium text-white">{{ tx.user?.name || 'Истифодабарандаи номаълум' }}</div>
                  <div class="text-xs text-brand-400 font-mono">ID: #{{ tx.id }}</div>
                </td>
                <td class="px-6 py-4 text-right text-surface-400">
                    {{ formatNumber(tx.balance_before) }}
                </td>
                <td class="px-6 py-4 text-right font-medium text-white">
                    {{ formatNumber(tx.amount) }}
                </td>
                <td class="px-6 py-4 text-right text-amber-400/80 text-sm">
                    {{ formatNumber(tx.commission) }}
                </td>
                <td class="px-6 py-4 text-right font-bold text-brand-400">
                    {{ formatNumber(parseFloat(tx.amount) + parseFloat(tx.commission)) }}
                </td>
                <td class="px-6 py-4 text-right text-surface-400">
                    {{ formatNumber(tx.balance_after) }}
                </td>
                <td class="px-6 py-4 text-center">
                  <span :class="getStatusClass(tx.status)">
                    {{ translateStatus(tx.status) }}
                  </span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-mono text-surface-400 max-w-[120px] truncate" :title="tx.external_reference">
                        {{ tx.external_reference || '...' }}
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-surface-500">
                    {{ formatDate(tx.created_at) }}
                </td>
              </tr>
              <tr v-if="transactions.length === 0">
                <td colspan="8" class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-surface-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="text-surface-500 font-medium">Дар таърих ягон транзаксия ёфт нашуд.</span>
                    </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Footer Action -->
      <div class="flex justify-center pt-4">
        <Link href="/" class="btn-secondary flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Бозгашт ба панел
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

defineProps({
  transactions: Array
});

const formatNumber = (num) => {
  return parseFloat(num).toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const translateStatus = (status) => {
  if (!status) return 'Номаълум';
  switch (status.toLowerCase()) {
    case 'success': return 'Муваффақ';
    case 'failed': return 'Хатогӣ';
    case 'pending': return 'Дар интизорӣ';
    default: return status;
  }
};

const getStatusClass = (status) => {
  if (!status) return 'status-badge bg-surface-500/10 text-surface-400 border border-surface-500/20';
  const base = 'status-badge ';
  switch (status.toLowerCase()) {
    case 'success': return base + 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20';
    case 'failed': return base + 'bg-red-500/10 text-red-400 border border-red-500/20';
    case 'pending': return base + 'bg-amber-500/10 text-amber-400 border border-amber-500/20';
    default: return base + 'bg-surface-500/10 text-surface-400 border border-surface-500/20';
  }
};
</script>
