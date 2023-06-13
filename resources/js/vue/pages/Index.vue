<template>
    <div class="w-6/12 p-10 mx-auto">
        <TopSection
            :user-name="userName"
            @handle-logout="handleLogout()"
        />

        <ErrorsLabel :errors="errors" />

        <NewCountry @add-country="addCountry" />

        <CountryList :countries="countries"  @delete-country="deleteCountry"/>
    </div>
</template>

<script setup>
    import {ref} from 'vue'
    import {useRouter} from "vue-router";
    import axios from "axios";
    import TopSection from "./components/TopSection.vue";
    import CountryList from "./components/CountryList.vue";
    import NewCountry from "./components/NewCountry.vue";
    import ErrorsLabel from "./components/ErrorsLabel.vue";

    const countries = ref([]);
    const router = useRouter();
    const errors = ref();
    const userName = ref('');
    let requestHeaders = '';

    const populateNameAndHeaders = () => {
        userName.value = localStorage.getItem('USER_NAME');
        const token = localStorage.getItem('USER_TOKEN')
        if (token !== undefined || token !== "") {
            requestHeaders = {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }
        }
    }

    const loadCountries = async () => {
        try {
            const response = await axios.get('/api/countries', requestHeaders);
            countries.value = response.data.data;
        } catch (e) {
            if (e && e.response && e.response.status === 401) {
                localStorage.removeItem('USER_NAME');
                localStorage.removeItem('USER_TOKEN');
                await router.push({name : 'Login'});
            }
        }
    }

    const handleLogout = () => {
                localStorage.removeItem('USER_TOKEN')
                router.push({name : 'Login'})
            }

    const deleteCountry = async (id) => {
        if (window.confirm("Are you sure")) {
            try {
                const response = await axios.delete(`/api/countries/${id}`, requestHeaders)
                if (response.status === 204) {
                    await loadCountries();
                }
            } catch (e) {
                await router.push({name : 'Login'})
            }
        }
    }

    const addCountry = async (country) => {
        errors.value = '';
        try {
            const response = await axios.post('/api/countries', country, requestHeaders);
            if (response.status === 201) {
                await loadCountries();
            }
        } catch (e) {
            if (e && e.response && e.response.status ) {
                switch (e.response.status) {
                    case 401:
                        localStorage.removeItem('USER_NAME');
                        localStorage.removeItem('USER_TOKEN');
                        await router.push({name : 'Login'});
                        break;
                    case 422:
                        if (e && e.response.data && e.response.data.errors) {
                            errors.value = Object.values(e.response.data.errors);
                        } else {
                            errors.value = e.response.data.message;
                        }
                        break;
                }
            }
        }
    }

    populateNameAndHeaders()
    loadCountries();

</script>
