<template>
  <div class="min-h-screen flex text-surface-200">
    <!-- Sidebar -->
    <aside class="w-64 glass-card m-4 mr-0 hidden lg:flex flex-col overflow-hidden border-white/5">
      <div class="p-6">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gradient-to-br from-brand-400 to-brand-600 rounded-xl shadow-lg shadow-brand-500/20 flex items-center justify-center text-white font-bold text-xl">
            P
          </div>
          <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-surface-400">
            PardoxtTJ
          </span>
        </div>
      </div>

      <nav class="flex-1 px-4 py-4 space-y-2">
        <Link href="/" :class="['flex items-center gap-3 px-4 py-3 rounded-xl transition-all', $page.component === 'Dashboard' ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20 shadow-sm shadow-brand-500/10' : 'hover:bg-white/5 hover:text-white']">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          Панел
        </Link>
        <Link href="/users/create" :class="['flex items-center gap-3 px-4 py-3 rounded-xl transition-all', $page.component === 'Users/Create' ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'hover:bg-white/5 hover:text-white']">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
          </svg>
          Иловаи корбар
        </Link>
        <Link href="/payments/create" :class="['flex items-center gap-3 px-4 py-3 rounded-xl transition-all', $page.component === 'Payments/Create' ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'hover:bg-white/5 hover:text-white']">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Пардохти нав
        </Link>
        <Link href="/transactions" :class="['flex items-center gap-3 px-4 py-3 rounded-xl transition-all', $page.component === 'Transactions/Index' ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'hover:bg-white/5 hover:text-white']">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
          </svg>
          Таърих
        </Link>
      </nav>

      <div class="p-4 mt-auto">
        <a href="/horizon" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 hover:text-white transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
          Мониторинг
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-8 flex flex-col gap-6">
      <!-- Top Bar -->
      <header class="flex justify-between items-center bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl px-6 py-4 lg:hidden">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center text-white font-bold">P</div>
          <span class="font-bold text-white">PardoxtTJ</span>
        </div>
        <button class="p-2 text-surface-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
          </svg>
        </button>
      </header>

      <div class="max-w-6xl mx-auto w-full">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
