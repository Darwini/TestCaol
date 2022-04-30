<template>
    <div class="text-center pt-4 pb-8 border-b border-gray-200">
        <button @click="loginWeb3">
            Inicia Sesión con MetaMask 
        </button>
    </div>
</template>

<script type="text/javascript">
    var token = document.querySelectorAll('meta[name="csrf-token"]')[0].content;
    var url = document.querySelectorAll('meta[name="url"]')[0].content;

    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import Web3 from 'web3/dist/web3.min.js'
    import { useForm } from '@inertiajs/inertia-vue3'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    
    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            },
            async loginWeb3() {
                if (!window.ethereum) {
                    alert('MetaMask not detected. Please try again from a MetaMask enabled browser.')
                }

                const web3 = new Web3(window.ethereum);

                const message = [
                    "I have read and accept the terms and conditions (https://example.org/tos) of this app.",
                    "Please sign me in!"
                ].join("\n")

                const address = (await web3.eth.requestAccounts())[0]
                const signature = await web3.eth.personal.sign(message, address)

                return useForm({ message, address, signature }).post(`${url}/login-web3`);
                /*if (rl === true ) {
                    return document.location.replace(`${url}/jugar`);
                }*/
            }
        }
    })
</script>
