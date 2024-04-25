<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from './InputLabel.vue';
import InputError from './InputError.vue';
import TextInput from './TextInput.vue';
import PrimaryButton from './PrimaryButton.vue';

const form = useForm({
    customer_name: '',
    contact_first_name: '',
    contact_last_name: '',
    phone: '',
    address_line1: '',
    address_line2: '',
    city: '',
    state: '',
    postal_code: '',
    country: ''
})

const submit = () => {
    form.post('/customer', {preserveScroll: true})
}

</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="customer_name" value="Customer Name" :required="true" />
                <TextInput
                    id="customer_name"
                    v-model="form.customer_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="customer_name"
                />
                <InputError class="mt-2" :message="form.errors.customer_name" />
                <InputLabel for="contact_first_name" value="First Name" class="mt-4" :required="true"/>
                <TextInput
                    id="contact_first_name"
                    v-model="form.contact_first_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="contact_first_name"
                />
                <InputError class="mt-2" :message="form.errors.contact_first_name" />
                <InputLabel for="contact_last_name" value="Last Name" class="mt-4" :required="true"/>
                <TextInput
                    id="contact_last_name"
                    v-model="form.contact_last_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="contact_last_name"
                />
                <InputError class="mt-2" :message="form.errors.contact_last_name" />
                <InputLabel for="phone" value="Phone" class="mt-4" :required="true"/>
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="phone"
                />
                <InputError class="mt-2" :message="form.errors.phone" />
                <InputLabel for="address_line1" value="Address Line 1" class="mt-4" :required="true"/>
                <TextInput
                    id="address_line1"
                    v-model="form.address_line1"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="address_line1"
                />
                <InputError class="mt-2" :message="form.errors.address_line1" />
                <InputLabel for="address_line2" value="Address Line 2" class="mt-4"/>
                <TextInput
                    id="address_line2"
                    v-model="form.address_line2"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="address_line2"
                />
                <InputError class="mt-2" :message="form.errors.address_line2" />
                <InputLabel for="city" value="City" class="mt-4" :required="true"/>
                <TextInput
                    id="city"
                    v-model="form.city"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="city"
                />
                <InputError class="mt-2" :message="form.errors.city" />
                <InputLabel for="state" value="State" class="mt-4"/>
                <TextInput
                    id="state"
                    v-model="form.state"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="state"
                />
                <InputError class="mt-2" :message="form.errors.state" />
                <InputLabel for="postal_code" value="Postal Code" class="mt-4"/>
                <TextInput
                    id="postal_code"
                    v-model="form.postal_code"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="postal_code"
                />
                <InputError class="mt-2" :message="form.errors.postal_code" />
                <InputLabel for="country" value="Country" class="mt-4" :required="true"/>
                <TextInput
                    id="country"
                    v-model="form.country"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="country"
                />
                <InputError class="mt-2" :message="form.errors.country" />
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </div>
</template>
