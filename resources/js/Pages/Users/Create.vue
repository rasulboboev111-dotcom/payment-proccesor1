<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-3xl font-bold">Иловаи истифодабаранда</h1>
          <p class="text-surface-400 mt-1">Истифодабарандаи нав илова кунед ва ба он баланс диҳед.</p>
        </div>
        <Link href="/" class="text-brand-400 hover:text-brand-300 transition-all flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Бозгашт
        </Link>
      </div>

      <!-- Form -->
      <div class="glass-card p-8">
        <form @submit.prevent="submit" class="space-y-6">
          <div class="space-y-2">
            <label for="name" class="block text-sm font-medium text-slate-500 dark:text-surface-300">Ном</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              class="glass-input w-full"
              placeholder="Номи пурра"
              required
            />
            <div v-if="form.errors.name" class="text-red-400 text-sm mt-1">{{ form.errors.name }}</div>
          </div>

          <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-slate-500 dark:text-surface-300">Email</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              class="glass-input w-full"
              placeholder="tsoy@example.com"
              required
            />
            <div v-if="form.errors.email" class="text-red-400 text-sm mt-1">{{ form.errors.email }}</div>
          </div>

          <div class="space-y-2">
            <label for="balance" class="block text-sm font-medium text-slate-500 dark:text-surface-300">Баланси аввалия</label>
            <div class="relative">
              <input
                id="balance"
                v-model="form.balance"
                type="number"
                step="0.01"
                min="0"
                class="glass-input w-full"
                placeholder="0.00"
                required
              />
              <div class="absolute right-4 top-1/2 -translate-y-1/2 text-surface-500">TJS</div>
            </div>
            <div v-if="form.errors.balance" class="text-red-400 text-sm mt-1">{{ form.errors.balance }}</div>
          </div>

          <div class="pt-4">
            <button
              type="submit"
              :disabled="form.processing"
              class="btn-primary w-full flex items-center justify-center gap-2 py-4"
            >
              <svg v-if="form.processing" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ form.processing ? 'Дар ҳоли иҷро...' : 'Илова кардан' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const form = useForm({
  name: '',
  email: '',
  balance: 0,
});

const submit = () => {
  form.post('/users', {
    onSuccess: () => form.reset(),
  });
};
</script>
