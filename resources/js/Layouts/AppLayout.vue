<template>
  <div :class="['min-h-screen flex transition-colors duration-300', isDark ? 'dark bg-surface-950' : 'bg-surface-50']">
    <!-- Sidebar -->
    <aside class="w-64 glass-card m-4 mr-0 hidden lg:flex flex-col overflow-hidden border-slate-200/50 dark:border-white/5">
      <div class="p-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-brand-400 to-brand-600 rounded-xl shadow-lg shadow-brand-500/20 flex items-center justify-center text-white font-bold text-xl">
              P
            </div>
            <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-500 dark:from-white dark:to-surface-400">
              PardoxtTJ
            </span>
          </div>
        </div>
      </div>

      <nav class="flex-1 px-4 py-4 space-y-2">
        <Link href="/" :class="['flex items-center gap-3 px-4 py-3 rounded-xl transition-all', $page.component === 'Dashboard' ? 'bg-brand-500/10 text-brand-500 dark:text-brand-400 border border-brand-500/20 shadow-sm shadow-brand-500/10' : 'text-slate-600 dark:text-surface-400 hover:bg-slate-100 dark:hover:bg-white/5 dark:hover:text-white']">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          Панел
        </Link>
        <Link href="/users" :class="['flex items-center gap-3 px-4 py-3 rounded-xl transition-all', $page.component === 'Users/Index' ? 'bg-brand-500/10 text-brand-500 dark:text-brand-400 border border-brand-500/20' : 'text-slate-600 dark:text-surface-400 hover:bg-slate-100 dark:hover:bg-white/5 dark:hover:text-white']">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          Мизоҷон
        </Link>
        <Link href="/payments/create" :class="['flex items-center gap-3 px-4 py-3 rounded-xl transition-all', $page.component === 'Payments/Create' ? 'bg-brand-500/10 text-brand-500 dark:text-brand-400 border border-brand-500/20' : 'text-slate-600 dark:text-surface-400 hover:bg-slate-100 dark:hover:bg-white/5 dark:hover:text-white']">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Пардохти нав
        </Link>
        <Link href="/transactions" :class="['flex items-center gap-3 px-4 py-3 rounded-xl transition-all', $page.component === 'Transactions/Index' ? 'bg-brand-500/10 text-brand-500 dark:text-brand-400 border border-brand-500/20' : 'text-slate-600 dark:text-surface-400 hover:bg-slate-100 dark:hover:bg-white/5 dark:hover:text-white']">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
          </svg>
          Таърих
        </Link>
      </nav>

      <div class="px-4 py-6 space-y-4 border-t border-slate-200/50 dark:border-white/5 mt-auto">
        <button @click="toggleTheme" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-surface-300 hover:scale-[1.02] active:scale-95 transition-all">
          <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 0A9 9 0 115.636 5.636m12.728 12.728L5.636 5.636" />
          </svg>
          <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
          </svg>
          {{ isDark ? 'Рӯз' : 'Шаб' }}
        </button>
        <a href="/horizon" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-surface-400 hover:bg-slate-100 dark:hover:bg-white/5 dark:hover:text-white transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
          Мониторинг
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-8 flex flex-col gap-6 overflow-y-auto max-h-screen">
      <!-- Top Bar (Mobile) -->
      <header class="flex justify-between items-center glass-card px-6 py-4 lg:hidden">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">P</div>
          <span class="font-bold text-slate-900 dark:text-white">PardoxtTJ</span>
        </div>
        <div class="flex items-center gap-2">
            <button @click="toggleTheme" class="p-2 text-slate-600 dark:text-surface-400">
                <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 0A9 9 0 115.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
            <button class="p-2 text-slate-600 dark:text-surface-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
              </svg>
            </button>
        </div>
      </header>

      <div class="max-w-6xl mx-auto w-full">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const isDark = ref(true);

onMounted(() => {
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme) {
    isDark.value = savedTheme === 'dark';
  } else {
    isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
  }
  updateTheme();
});

const toggleTheme = () => {
  isDark.value = !isDark.value;
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
  updateTheme();
};

const updateTheme = () => {
  if (isDark.value) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
};
</script>
