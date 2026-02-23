<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto space-y-8">
      <!-- Header -->
      <div class="flex items-center gap-4">
        <Link href="/" class="p-2 glass-card hover:bg-white/10 transition-all text-surface-400 hover:text-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </Link>
        <div>
          <h1 class="text-3xl font-bold">Пардохти нав</h1>
          <p class="text-surface-400 mt-1">Транзаксияи бехатари пардохтро оғоз кунед.</p>
        </div>
      </div>

      <!-- Form -->
      <div class="glass-card p-8">
        <form @submit.prevent="submit" class="space-y-6">
          <div class="space-y-2">
            <label class="text-sm font-medium text-surface-400 ml-1">Интихоби истифодабаранда</label>
            <div class="relative">
              <select v-model="form.user_id" class="glass-input w-full appearance-none pr-10">
                <option value="" disabled class="bg-white dark:bg-surface-900 text-slate-900 dark:text-white">Қабулкунандаро интихоб кунед...</option>
                <option v-for="user in users" :key="user.id" :value="user.id" class="bg-white dark:bg-surface-900 text-slate-900 dark:text-white">
                  {{ user.name }} (Баланс: {{ formatNumber(user.balance) }} TJS)
                </option>
              </select>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-surface-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>

          <div class="space-y-4">
            <label class="text-sm font-medium text-surface-400 ml-1">Намуди транзаксия</label>
            <div class="grid grid-cols-3 gap-4">
              <button 
                type="button"
                @click="form.type = 'deposit'"
                :class="[
                  'p-4 rounded-xl border transition-all flex flex-col items-center gap-2',
                  form.type === 'deposit' 
                    ? 'bg-emerald-500/10 border-emerald-500/50 text-emerald-400' 
                    : 'glass-card border-white/5 text-surface-400 hover:bg-white/5'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="font-medium text-xs">Зиёд кардан</span>
              </button>
              <button 
                type="button"
                @click="form.type = 'withdrawal'"
                :class="[
                  'p-4 rounded-xl border transition-all flex flex-col items-center gap-2',
                  form.type === 'withdrawal' 
                    ? 'bg-amber-500/10 border-amber-500/50 text-amber-400' 
                    : 'glass-card border-white/5 text-surface-400 hover:bg-white/5'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
                <span class="font-medium text-xs">Кам кардан</span>
              </button>
              <button 
                type="button"
                @click="form.type = 'payment'"
                :class="[
                  'p-4 rounded-xl border transition-all flex flex-col items-center gap-2',
                  form.type === 'payment' 
                    ? 'bg-brand-500/10 border-brand-500/50 text-brand-400' 
                    : 'glass-card border-white/5 text-surface-400 hover:bg-white/5'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="font-medium text-xs">Пардохт (2%)</span>
              </button>
            </div>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-surface-400 ml-1">Маблағ</label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-400 font-bold">TJS</span>
              <input 
                type="number" 
                step="0.01" 
                v-model="form.amount" 
                placeholder="0.00"
                class="glass-input w-full pl-14 font-mono text-lg font-medium"
              >
            </div>
            
            <!-- Real-time Commission and Total -->
            <div v-if="form.amount > 0" class="mt-4 p-4 rounded-xl bg-slate-100 dark:bg-surface-800/50 border border-slate-200/50 dark:border-white/5 space-y-2 animate-in fade-in slide-in-from-top-2 duration-300">
              <div v-if="form.type === 'payment'" class="flex justify-between text-sm">
                <span class="text-slate-500 dark:text-surface-400">Комиссия (2%):</span>
                <span class="text-slate-900 dark:text-surface-200 font-mono">{{ formatNumber(commission) }} TJS</span>
              </div>
              <div class="flex justify-between text-base font-bold">
                <span class="text-slate-900 dark:text-surface-200">
                  {{ form.type === 'deposit' ? 'Маблағи иловашаванда:' : (form.type === 'payment' ? 'Ҳамагӣ барои пардохт:' : 'Ҳамагӣ барои кам кардан:') }}
                </span>
                <span :class="[form.type === 'deposit' ? 'text-emerald-400' : 'text-brand-600 dark:text-brand-400', 'font-mono']">
                  {{ formatNumber(totalAmount) }} TJS
                </span>
              </div>
            </div>
          </div>

          <div v-if="success" class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>Транзаксия бомуваффақият иҷро шуд!</p>
          </div>

          <div v-if="error" class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>{{ error }}</p>
          </div>

          <button 
            type="submit" 
            class="btn-primary w-full py-4 text-lg shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="processing"
          >
            <span v-if="processing" class="flex items-center justify-center gap-2">
              <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Дар коркард...
            </span>
            <span v-else>Иҷро кардан</span>
          </button>
        </form>
      </div>

      <!-- Security Note -->
      <div class="flex items-center justify-center gap-2 text-surface-500 text-sm italic">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
        Транзаксияи бехатар бо идемпотентӣ ва рамзгузории 256-бит.
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import axios from 'axios';
import AppLayout from '../../Layouts/AppLayout.vue';

defineProps({
  users: Array
});

const form = reactive({
  user_id: '',
  amount: '',
  type: 'withdrawal'
});

const commission = computed(() => {
  if (form.type !== 'payment') return 0;
  const amt = parseFloat(form.amount) || 0;
  return amt * 0.02;
});

const totalAmount = computed(() => {
  const amt = parseFloat(form.amount) || 0;
  return amt + commission.value;
});

const processing = ref(false);
const success = ref(false);
const error = ref(null);

const generateIdempotencyKey = () => {
    return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
};

const formatNumber = (num) => {
  return parseFloat(num).toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
};

const submit = () => {
  if (!form.user_id || !form.amount) {
    error.value = 'Лутфан истифодабаранда ва маблағро интихоб кунед.';
    return;
  }

  processing.value = true;
  error.value = null;
  success.value = false;

  axios.post('/api/payments', form, {
    headers: {
      'Idempotency-Key': generateIdempotencyKey()
    }
  }).then(response => {
    success.value = true;
    form.user_id = '';
    form.amount = '';
    setTimeout(() => {
        router.visit('/');
    }, 2000);
  }).catch(err => {
    error.value = err.response?.data?.error || err.response?.data?.message || 'Хатогӣ рӯй дод. Лутфан дубора кӯшиш кунед.';
  }).finally(() => {
    processing.value = false;
  });
};
</script>
