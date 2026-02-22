<template>
  <AppLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold">Рӯйхати мизоҷон</h1>
          <p class="text-surface-400 mt-1">Идоракунӣ ва мониторинги баланси истифодабарандагон.</p>
        </div>
        <div class="flex gap-4">
          <Link href="/users/create" class="btn-primary flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Илова кардани мизоҷ
          </Link>
        </div>
      </div>

      <!-- Users List -->
      <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="text-surface-500 text-sm uppercase tracking-wider">
                <th class="px-6 py-4 font-semibold">Истифодабаранда</th>
                <th class="px-6 py-4 font-semibold">Email</th>
                <th class="px-6 py-4 font-semibold text-right">Начальный баланс</th>
                <th class="px-6 py-4 font-semibold text-right">Текущий баланс</th>
                <th class="px-6 py-4 font-semibold">Санаи сабт</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
              <tr v-for="user in users" :key="user.id" class="hover:bg-white/5 transition-all">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-brand-500/10 flex items-center justify-center text-brand-600 dark:text-brand-400 font-bold">
                        {{ user.name.charAt(0) }}
                    </div>
                    <div class="font-medium text-slate-900 dark:text-white">{{ user.name }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 text-slate-500 dark:text-surface-400">
                    {{ user.email }}
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="text-sm font-medium text-slate-500 dark:text-surface-400">{{ formatNumber(user.initial_balance) }}</div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="text-lg font-bold text-slate-900 dark:text-white">{{ formatNumber(user.balance) }} <span class="text-xs text-slate-500 dark:text-surface-500">TJS</span></div>
                </td>
                <td class="px-6 py-4 text-sm text-surface-500">
                    {{ formatDate(user.created_at) }}
                </td>
              </tr>
              <tr v-if="users.length === 0">
                <td colspan="4" class="px-6 py-20 text-center text-surface-500">
                    Ягон истифодабаранда ёфт нашуд.
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
  users: Array
});

const formatNumber = (num) => {
  return parseFloat(num).toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('tj-TJ', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
};
</script>
