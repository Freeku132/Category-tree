<template>
    <button class="ml-1" @click="showEditForm(element)"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="15px" height="15px">    <path d="M 22.828125 3 C 22.316375 3 21.804562 3.1954375 21.414062 3.5859375 L 19 6 L 24 11 L 26.414062 8.5859375 C 27.195062 7.8049375 27.195062 6.5388125 26.414062 5.7578125 L 24.242188 3.5859375 C 23.851688 3.1954375 23.339875 3 22.828125 3 z M 17 8 L 5.2597656 19.740234 C 5.2597656 19.740234 6.1775313 19.658 6.5195312 20 C 6.8615312 20.342 6.58 22.58 7 23 C 7.42 23.42 9.6438906 23.124359 9.9628906 23.443359 C 10.281891 23.762359 10.259766 24.740234 10.259766 24.740234 L 22 13 L 17 8 z M 4 23 L 3.0566406 25.671875 A 1 1 0 0 0 3 26 A 1 1 0 0 0 4 27 A 1 1 0 0 0 4.328125 26.943359 A 1 1 0 0 0 4.3378906 26.939453 L 4.3632812 26.931641 A 1 1 0 0 0 4.3691406 26.927734 L 7 26 L 5.5 24.5 L 4 23 z"/></svg></button>
    <div v-if="visibleEditForm">
        <div class="z-50 fixed inset-0 w-full h-screen flex items-center justify-center">
            <div class="md:w-2/3 flex flex-col bg-gray-500 rounded-xl m-4 p-4">
                <div class="text-right">
                    <button type="button" class="text-right rounded px-2 bg-red-500" @click="visibleEditForm = !visibleEditForm & editForm.clearErrors()">x</button>
                </div>
                <div class="flex flex-col w-2/3 space-y-4">
                    <div class="flex flex-col">
                        <label class="font-bold">Name:</label>
                        <input v-model="editForm.name" type="text" required>
                        <div class=" font-semibold text-red-700 " v-html="editForm.errors.name" />
                    </div>
                </div>
                <button class="bg-green-600 w-1/6 mt-4 disabled:bg-gray-500" type="button" @click="submitEditForm" :disabled="editForm.processing">Edit</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";

let props = defineProps({
    category : Object
})

let visibleEditForm = ref(false);

let showEditForm = () => {
    visibleEditForm.value = true;

    editForm.name = props.category.name
    editForm.id = props.category.id

}

let editForm = useForm({
    'name': '',
    'id':''
})

let submitEditForm = () => {
    editForm.post('/category/update', {
        onSuccess: () => {
            visibleEditForm.value = false;
        }
    })
}

</script>

<style scoped>

</style>
