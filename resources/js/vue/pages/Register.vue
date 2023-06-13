<template>
    <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col">
            <h1 class="text-gray-600 py-5 font-bold text-3xl"> Create Account </h1>
            <ErrorsLabel :errors="errors" />
            <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>
            <form method="post" @submit.prevent="handleSubmit">
                <div class="mb-4 mt-3">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="name"
                    >
                        Name
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                        id="name"
                        type="text"
                        required
                        v-model="form.name"
                    />
                </div>
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="email"
                    >
                        Email Address
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                        type="email"
                        id="email"
                        required
                        v-model="form.email"
                    />
                </div>
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="password"
                    >
                        Password
                    </label>
                    <input
                        class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                        id="password"
                        type="password"
                        required
                        v-model="form.password"
                    />
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                        type="submit"
                    >
                        Register
                    </button>
                    <router-link
                        class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                        to="Login"
                    >
                        Login
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
    import { reactive, ref } from 'vue';
    import axios from 'axios';
    import { useRouter } from "vue-router";
    import ErrorsLabel from "./components/ErrorsLabel.vue";

    const errors = ref();
    let router = useRouter();

    const form = reactive({
        name     : '',
        email    : '',
        password : ''
    })

    const handleSubmit = async (evt) => {
        const defaultErrorMessage = 'Unexpected register error. Please try again.';
        errors.value = null;

        try {
            const result = await axios.post('/api/auth/register', form);
            if (result.status === 200 && result.data && result.data.token) {
                localStorage.setItem('USER_TOKEN', result.data.token);
                localStorage.setItem('USER_NAME', result.data.userName);
                await router.push({name : 'Index'});
            }
        } catch (e) {
            if (e.response.data && e.response.data.errors) {
                errors.value = Object.values(e.response.data.errors);
            } else {
                errors.value = e.response.data.message || defaultErrorMessage;
            }
        }
    }
</script>
