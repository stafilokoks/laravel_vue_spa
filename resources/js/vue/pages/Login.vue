<template>
    <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
        <div class="bg-white shadow-lg rounded-lg p x-8 p-6 flex flex-col">
            <h1 class="text-gray-600 py-5 font-bold text-3xl"> Login </h1>
            <ErrorsLabel :errors="errors" />
            <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>
            <form method="post" @submit.prevent="handleLogin">
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="username"
                    >
                        Email Address
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                        id="username"
                        type="text"
                        v-model="form.email"
                        required
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
                        v-model="form.password"
                        required
                    />
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                        type="submit"
                    >
                        Sign In
                    </button>
                    <router-link
                        class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                        to="Register"
                    >
                        Sign Up
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";
import ErrorsLabel from "./components/ErrorsLabel.vue";

export default {
    components : {ErrorsLabel},
    setup() {
        const errors = ref();
        const router = useRouter();
        const form = reactive({
            email    : '',
            password : ''
        });
        const handleLogin = async () => {
            const defaultErrorMessage = 'Unexpected login error. Please try again.';
            errors.value = null;

            try {
                const result = await axios.post('/api/auth/login', form)
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('USER_TOKEN', result.data.token);
                    localStorage.setItem('USER_NAME', result.data.userName);
                    await router.push({name : 'Index'});
                } else {
                    errors.value = defaultErrorMessage;
                }
            } catch (e) {
                if (e && e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors);
                } else {
                    errors.value = e.response.data.message || defaultErrorMessage;
                }
            }
        }

        return {
            form,
            errors,
            handleLogin
        }
    }
}
</script>
