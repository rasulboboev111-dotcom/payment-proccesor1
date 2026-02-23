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
                <th class="px-6 py-4 font-semibold text-center">Намуд</th>
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
              <tr v-for="tx in transactions.data" :key="tx.id" class="hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                <td class="px-6 py-4">
                  <div class="font-medium text-slate-900 dark:text-white">{{ tx.user?.name || 'Истифодабарандаи номаълум' }}</div>
                  <div class="text-xs text-brand-600 dark:text-brand-400 font-mono">ID: #{{ tx.id }}</div>
                </td>
                <td class="px-6 py-4 text-center">
                  <span :class="getTypeClass(tx.type)">
                    {{ translateType(tx.type) }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right text-slate-500 dark:text-surface-400">
                    {{ formatNumber(tx.balance_before) }}
                </td>
                <td class="px-6 py-4 text-right font-medium text-slate-900 dark:text-white">
                    {{ formatNumber(tx.amount) }}
                </td>
                <td class="px-6 py-4 text-right text-amber-600 dark:text-amber-400/80 text-sm">
                    {{ formatNumber(tx.commission) }}
                </td>
                <td class="px-6 py-4 text-right font-bold text-brand-600 dark:text-brand-400">
                    {{ formatNumber(parseFloat(tx.amount) + parseFloat(tx.commission)) }}
                </td>
                <td class="px-6 py-4 text-right text-slate-500 dark:text-surface-400">
                    {{ formatNumber(tx.balance_after) }}
                </td>
                <td class="px-6 py-4 text-center">
                  <span :class="getStatusClass(tx.status)">
                    {{ translateStatus(tx.status) }}
                  </span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-mono text-slate-500 dark:text-surface-400 max-w-[120px] truncate" :title="tx.external_reference">
                        {{ tx.external_reference || '...' }}
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-surface-500">
                    {{ formatDate(tx.created_at) }}
                </td>
              </tr>
              <tr v-if="transactions.data.length === 0">
                <td colspan="10" class="px-6 py-20 text-center">
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

        <!-- Pagination -->
        <div v-if="transactions.links.length > 3" class="px-6 py-4 border-t border-white/5 flex items-center justify-between bg-black/5">
            <div class="text-sm text-surface-500">
                Намоиши {{ transactions.from }} то {{ transactions.to }} аз {{ transactions.total }} транзаксия
            </div>
            <div class="flex gap-2">
                <Link
                    v-for="(link, k) in transactions.links"
                    :key="k"
                    :href="link.url || '#'"
                    v-html="link.label"
                    class="px-3 py-1 rounded-md text-sm transition-all"
                    :class="[
                        link.active ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/20' : 'glass-card hover:bg-white/10 text-surface-400',
                        !link.url ? 'opacity-50 cursor-not-allowed' : ''
                    ]"
                />
            </div>
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
  transactions: Object
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

const translateType = (type) => {
  if (!type) return 'Пардохт';
  switch (type.toLowerCase()) {
    case 'deposit': return 'Зиёд кардан';
    case 'withdrawal': return 'Кам кардан';
    case 'payment': return 'Пардохти муқаррарӣ';
    default: return type;
  }
};

const getTypeClass = (type) => {
  const base = 'px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap inline-block ';
  if (type === 'deposit') return base + 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20';
  if (type === 'payment') return base + 'bg-brand-500/10 text-brand-400 border border-brand-500/20';
  return base + 'bg-amber-500/10 text-amber-400 border border-amber-500/20';
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
