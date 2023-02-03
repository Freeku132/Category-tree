<template>
    <button class="ml-1 py-0 px-1.5 rounded-full bg-red-600 hover:bg-red-700" @click="showDeleteForm()">x</button>
    <div v-if="visibleDeleteForm">
        <div class="z-50 fixed inset-0 w-full h-screen flex items-center justify-center">
            <div class="w-2/3 flex flex-col bg-gray-500 rounded-xl m-4 p-4">
                <div class="text-right">
                    <button type="button" class="text-right rounded px-2 bg-red-500" @click="visibleDeleteForm = false">x</button>
                </div>
                <div class="flex flex-col w-2/3 space-y-4">
                    Are you sure you want to delete the {{deleteForm.name}}?
                </div>
                <div class="flex space-x-6 h-20">
                    <button class="bg-green-600 w-1/6 mt-4 disabled:bg-gray-500" type="button" @click="submitDeleteForm(false)" :disabled="deleteForm.processing">Delete without sub</button>
                    <button class="bg-green-600 w-1/6 mt-4 disabled:bg-gray-500" type="button" @click="submitDeleteForm(true)" :disabled="deleteForm.processing">Delete with sub</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";

let props = defineProps({
    category : Object
})

let visibleDeleteForm = ref(false);

let showDeleteForm = () => {
    visibleDeleteForm.value = true;

    deleteForm.id = props.category.id
    deleteForm.name = props.category.name
}

let deleteForm = useForm({
    'id': '',
    'name': '',
    'delete_sub': ''
})

let submitDeleteForm = (value) => {
    deleteForm.delete_sub = value
    deleteForm.post('/category/delete', {
        preserveState: true,
        onSuccess: () => {
            visibleDeleteForm.value = false;
            alert(usePage().props.flash.success_message)
        }
    })
}
</script>

<style scoped>

</style>
