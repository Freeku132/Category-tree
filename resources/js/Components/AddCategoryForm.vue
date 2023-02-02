<template>
    <button class="ml-1 py-0 px-1.5 rounded-full bg-green-600 hover:bg-green-700" @click="showAddForm()">+</button>
    <div v-if="visibleAddForm">
        <div class="z-50 fixed inset-0 w-full h-screen flex items-center justify-center">
            <div class="md:w-2/3 flex flex-col bg-gray-500 rounded-xl m-4 p-4">
                <div class="text-right">
                    <button type="button" class="text-right rounded px-2 bg-red-500" @click="visibleAddForm = !visibleAddForm & addForm.clearErrors()">x</button>
                </div>
                <div class="flex flex-col w-2/3 space-y-4">
                    <div class="flex flex-col">
                        <label class="font-bold">Name:</label>
                        <input v-model="addForm.name" type="text" required>
                        <div class=" font-semibold text-red-700 " v-html="addForm.errors.name" />
                    </div>
                </div>
                <button class="bg-green-600 w-1/6 mt-4 disabled:bg-gray-500" type="button" @click="submitAddForm" :disabled="addForm.processing">Add</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

let props = defineProps({
    category: Object,
    categories : Object
})

let visibleAddForm = ref(false);

let showAddForm = () => {
    visibleAddForm.value = true;

    if(props.category != null) {

        addForm.category_parent_id = props.category.id
        addForm.order = props.category.all_sub_categories.length + 1
        addForm.name = null

    } else {

        addForm.category_parent_id = null
        addForm.order = props.categories.length + 1
        addForm.name = null
    }
}

let addForm = useForm({
    'name': '',
    'category_parent_id': '',
    'order': '',
})
let submitAddForm = () => {
    addForm.post('/category', {
        onSuccess: () => {
            visibleAddForm.value = false;
        }
    })
}

</script>

<style scoped>

</style>
