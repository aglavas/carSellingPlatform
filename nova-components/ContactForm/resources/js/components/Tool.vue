<template>
    <div>
        <div>

        </div>
        <form autocomplete="off"
              @submit="sendRequest">
            <div class="mb-8"><h1 class="text-90 font-normal text-2xl mb-3">Contact Form</h1> <!---->

                <div class="card">
                    <p class="w-full p-8">Use the below field to ask a question not covered by the <a href="https://emilfrey.carmarket.io/carmarket_manual_13082020.pdf" class="font-bold" target="_blank">manual</a> or instructions. Feedback is also very much welcomed.
                    </p>
                    <div class="flex border-b border-40"
                         resource-id="2">

                        <div class="w-1/5 px-8 py-6"><label for="title"
                                                            class="inline-block text-80 pt-2 leading-tight"> Message
                                                                                                             <!----></label>
                        </div>
                        <div class="py-6 px-8 w-1/2">

                           <textarea class="w-full form-control form-input form-input-bordered py-3 h-auto"
                                     type="text"
                                     v-model="message"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <button type="submit"
                        class="btn btn-default btn-primary inline-flex items-center relative ml-auto"
                        dusk="update-button">
                    <span class="">
        Send
      </span> <!----></button>
            </div>
        </form>
    </div>
</template>
<script>
  export default {

    mounted () {
      this.formSubmitted = false
    },
    data: function () {
      return {
        message: '',
        formSubmitted: false
      }
    },
    methods: {
      sendRequest: function (e) {
        this.$toasted.show('Message is being sent...', { type: 'info' })
        axios.post('/nova-vendor/contact-form/store', {message: this.message})
          .then(response => {
            this.$toasted.show('Thank you for you message. We will try to get back to you as soon as possible.', {type: 'success'})
            this.message = ''
            })
          .catch(function (error) {
            // handle error
            this.$toasted.show('There has been an error :(', {type: 'error'})
          })
        e.preventDefault()
      }
    }
  }
</script>
<style>
    /* Scoped Styles */
</style>
