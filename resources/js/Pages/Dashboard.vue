<template>
  <AppLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold">Панели идоракунӣ</h1>
          <p class="text-slate-500 dark:text-surface-400 mt-1">Нишондиҳандаҳои молиявии худро назорат кунед.</p>
        </div>
        <div class="flex gap-4">
          <Link href="/payments/create" class="btn-primary flex items-center gap-2 w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Пардохти нав
          </Link>
        </div>
      </div>

      <!-- Stats Overview -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-card p-6 border-brand-500/10 hover:border-brand-500/30 transition-all">
          <p class="text-slate-500 dark:text-surface-400 text-sm font-medium">Ҳаҷми умумии пардохтҳо</p>
          <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ formatNumber(stats.total_volume) }} <span class="text-brand-600 dark:text-brand-400 text-sm">TJS</span></div>
          <div class="mt-2 text-xs text-brand-400 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            Ҳама вақт
          </div>
        </div>
        <div class="glass-card p-6 border-amber-500/10 hover:border-amber-500/30 transition-all">
          <p class="text-slate-500 dark:text-surface-400 text-sm font-medium">Ҷамъи комиссияҳо</p>
          <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ formatNumber(stats.total_commission) }} <span class="text-amber-600 dark:text-amber-400 text-sm">TJS</span></div>
          <div class="mt-2 text-xs text-amber-400 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Даромади соф
          </div>
        </div>
        <div class="glass-card p-6 border-surface-500/10 hover:border-surface-500/30 transition-all">
          <p class="text-slate-500 dark:text-surface-400 text-sm font-medium">Миқдори мизоҷон</p>
          <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ stats.active_users_count }}</div>
          <div class="mt-2 text-xs text-surface-500 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Корбарони фаъол
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Динамикаи пардохтҳо (30 рӯз)</h3>
            <div class="text-xs text-slate-500 dark:text-surface-500 uppercase tracking-widest font-semibold font-mono">Volume</div>
          </div>
          <div class="h-[300px]">
            <apexchart type="area" height="100%" :options="volumeChartOptions" :series="volumeChartSeries"></apexchart>
          </div>
        </div>
        <div class="glass-card p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Даромади комиссия</h3>
            <div class="text-xs text-amber-600 dark:text-amber-500 uppercase tracking-widest font-semibold font-mono">Revenue</div>
          </div>
          <div class="h-[300px]">
             <apexchart type="bar" height="100%" :options="commissionChartOptions" :series="commissionChartSeries"></apexchart>
          </div>
        </div>
      </div>

      <!-- Users Grid -->
      <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold">Баланси мизоҷон</h2>
            <Link href="/users" class="text-brand-500 dark:text-brand-400 hover:text-brand-600 dark:hover:text-brand-300 text-sm font-medium transition-all">Мониторинг</Link>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div v-for="user in users" :key="user.id" class="glass-card p-4 flex items-center gap-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                <div class="w-10 h-10 rounded-full bg-brand-500/10 flex items-center justify-center text-brand-600 dark:text-brand-400 font-bold">
                    {{ user.name.charAt(0) }}
                </div>
                <div>
                    <div class="font-medium text-slate-900 dark:text-white text-sm">{{ user.name }}</div>
                    <div class="text-xs text-slate-500 dark:text-surface-500">{{ formatNumber(user.balance) }} TJS</div>
                </div>
            </div>
        </div>
      </div>

        <!-- Recent Transactions -->
        <div class="glass-card overflow-hidden">
          <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-xl font-bold">Транзаксияҳои охирин</h2>
            <Link href="/transactions" class="text-brand-400 hover:text-brand-300 text-sm font-medium transition-all">Ҳамааш</Link>
          </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="text-surface-500 text-sm uppercase tracking-wider">
                <th class="px-6 py-4 font-semibold">Истифодабаранда</th>
                <th class="px-6 py-4 font-semibold">Баланси аввалия</th>
                <th class="px-6 py-4 font-semibold text-right">Маблағ</th>
                <th class="px-6 py-4 font-semibold text-right text-amber-400">Комиссия</th>
                <th class="px-6 py-4 font-semibold text-right text-brand-400">Ҷамъ</th>
                <th class="px-6 py-4 font-semibold">Баланси ниҳоӣ</th>
                <th class="px-6 py-4 font-semibold text-center">Статус</th>
                <th class="px-6 py-4 font-semibold text-right">Рамз</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-white/5">
              <tr v-for="tx in recentTransactions" :key="tx.id" class="hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                <td class="px-6 py-4">
                  <div class="font-medium text-slate-900 dark:text-white">{{ tx.user.name }}</div>
                  <div class="text-xs text-slate-500 dark:text-surface-500 font-mono">ID: #{{ tx.id }}</div>
                </td>
                <td class="px-6 py-4 text-slate-500 dark:text-surface-400 text-right">{{ formatNumber(tx.balance_before) }}</td>
                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white text-right">{{ formatNumber(tx.amount) }}</td>
                <td class="px-6 py-4 text-amber-600 dark:text-amber-400/80 text-sm text-right">{{ formatNumber(tx.commission) }}</td>
                <td class="px-6 py-4 font-bold text-brand-600 dark:text-brand-400 text-right">{{ formatNumber(parseFloat(tx.amount) + parseFloat(tx.commission)) }}</td>
                <td class="px-6 py-4 text-slate-500 dark:text-surface-400 font-medium text-right">{{ formatNumber(tx.balance_after) }}</td>
                <td class="px-6 py-4 text-center">
                  <span :class="getStatusClass(tx.status)">
                    {{ translateStatus(tx.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm font-mono text-slate-500 dark:text-surface-400 text-right">{{ tx.external_reference || '...' }}</td>
              </tr>
              <tr v-if="recentTransactions.length === 0">
                <td colspan="7" class="px-6 py-12 text-center text-surface-500">Транзаксияҳо ёфт нашуданд.</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="px-6 py-4 border-t border-white/5 bg-white/2 rounded-b-2xl">
          <Link href="/transactions" class="btn-secondary w-full flex items-center justify-center gap-2 group p-2">
            Дидани ҳамаи транзаксияҳо
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </Link>
        </div>
      </div>

    </div>
  </AppLayout>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
  users: Array,
  recentTransactions: Array,
  stats: Object
});

const isDark = ref(true);

onMounted(() => {
  // Check global theme
  const observer = new MutationObserver(() => {
    isDark.value = document.documentElement.classList.contains('dark');
  });
  observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
  isDark.value = document.documentElement.classList.contains('dark');
});

const apexchart = VueApexCharts;

const formatNumber = (num) => {
  return parseFloat(num).toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
};

// Chart Data Processing
const volumeChartSeries = computed(() => [{
  name: 'Ҳаҷми маблағ',
  data: props.stats.daily_stats.map(s => parseFloat(s.total_amount))
}]);

const volumeChartOptions = computed(() => ({
  chart: {
    fontFamily: 'Inter, sans-serif',
    toolbar: { show: false },
    background: 'transparent'
  },
  theme: { mode: isDark.value ? 'dark' : 'light' },
  stroke: { curve: 'smooth', width: 3, colors: ['#4f69ff'] },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 1,
      opacityFrom: 0.45,
      opacityTo: 0.05,
      stops: [20, 100],
      colorStops: [
        { offset: 0, color: '#4f69ff', opacity: 0.4 },
        { offset: 100, color: '#4f69ff', opacity: 0 }
      ]
    }
  },
  xaxis: {
    categories: props.stats.daily_stats.map(s => s.date),
    labels: { style: { colors: isDark.value ? '#94a3b8' : '#64748b' } },
    axisBorder: { show: false },
    axisTicks: { show: false }
  },
  yaxis: {
    labels: { style: { colors: isDark.value ? '#94a3b8' : '#64748b' }, formatter: (v) => v.toFixed(0) }
  },
  grid: { borderColor: isDark.value ? '#1e293b' : '#e2e8f0', strokeDashArray: 4 },
  dataLabels: { enabled: false },
  tooltip: { theme: isDark.value ? 'dark' : 'light', x: { show: true } }
}));

const commissionChartSeries = computed(() => [{
  name: 'Комиссия',
  data: props.stats.daily_stats.map(s => parseFloat(s.total_commission))
}]);

const commissionChartOptions = computed(() => ({
  chart: {
    fontFamily: 'Inter, sans-serif',
    toolbar: { show: false },
    background: 'transparent'
  },
  theme: { mode: isDark.value ? 'dark' : 'light' },
  plotOptions: {
    bar: {
      borderRadius: 6,
      columnWidth: '40%',
    }
  },
  colors: ['#f59e0b'],
  xaxis: {
    categories: props.stats.daily_stats.map(s => s.date),
    labels: { style: { colors: isDark.value ? '#94a3b8' : '#64748b' } },
    axisBorder: { show: false },
    axisTicks: { show: false }
  },
  yaxis: {
    labels: { style: { colors: isDark.value ? '#94a3b8' : '#64748b' }, formatter: (v) => v.toFixed(0) }
  },
  grid: { borderColor: isDark.value ? '#1e293b' : '#e2e8f0', strokeDashArray: 4 },
  dataLabels: { enabled: false }
}));

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
