
<template>
    <Head title="Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cateogory</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 space-y-5">
                        <div class="flex">
                        <div v-if="$page.props.auth.admin">
                            <button v-show="move" class="bg-gray-300 py-1 px-1 rounded-md" @click="move = false">Disable movement</button>
                            <button v-show="!move" class="bg-gray-300 py-1 px-1 rounded-md" @click="move = true">Enable movement</button>
                        </div>
                            <button class="bg-gray-300 ml-4 py-1 px-1 rounded-md" @click="showAll()">Show all</button>
                            <button class="bg-gray-300 ml-4 py-1 px-1 rounded-md" @click="hideAll()">Hide all</button>
                        </div>

                        <AddCategoryForm v-if="$page.props.auth.admin" :category="null" :categories="props.categories"/>


                        <draggable
                            class="dragArea  relative transition duration-200"
                            tag="ul"
                            :list="categories"
                            item-key="name"
                            @update="update"
                            @add="update"
                            :group="{ name: 'categories' }"
                            v-bind="dragOptions()"
                            :disabled="move"
                        >

                            <template #item="{ element }">
                                <li class=" categories relative">
                                    <div class="flex -ml-4 category">
                                        <p class="">{{ element.name }}</p>
                                        <AddCategoryForm v-if="$page.props.auth.admin" :category="element" :categories="null"/>
                                        <DeleteCategoryForm v-if="$page.props.auth.admin" :category="element"/>
                                        <EditCategoryForm v-if="$page.props.auth.admin" :category="element"/>
                                    </div>
                                    <div class="ml-5">
                                        <TreeChild :show="show" :category="element.id" :move="move"  :categories="element.all_sub_categories"/>
                                    </div>
                                </li>
                            </template>
                        </draggable>



                    </div>
                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import draggable from 'vuedraggable';
import TreeChild from "@/Components/TreeChild.vue";
import {ref} from "vue";
import AddCategoryForm from "@/Components/AddCategoryForm.vue";
import EditCategoryForm from "@/Components/EditCategoryForm.vue";
import DeleteCategoryForm from "@/Components/DeleteCategoryForm.vue";



let props = defineProps({
    categories: Object
})
let move = ref(true);

let show = ref({
    show: '',
    count: 1,
})

let showAll = () =>{
    show.value.show = true
    show.value.count = show.value.count + 1
}

let hideAll = () =>{
    show.value.show = false
    show.value.count = show.value.count + 1
}



// SORT
let categoriesForm = useForm({
    'categories' :'',
    'category_parent': ''
})

let update = () => {
    props.categories.map((category, index) => {
        category.order = index +1;
    });
    categoriesForm.categories = props.categories
    categoriesForm.category_parent = null

    categoriesForm.post('/category/sort')
}



// DRAG ANIMATION
let dragOptions = () =>{
    return {
        animation: 200,
        group: "description",
        disabled: false,
        ghostClass: "ghost"
    };
}


</script>
<style>
.dragArea {
    min-height: 50px;
    outline: 1px dashed;
}

.categories::before {
    position: absolute;
    display: block;
    top: 0;
    left: -20px;
    content: "";
    width: 3px;
    height: 100%;
    background: gray;
}

.category::before {
    position: relative;
    display: block;
    top: 9px;
    content: "";
    width: 25px;
    height: 3px;
    background: gray;
    left: -4px;
}



.flip-list-move {
    transition: transform 0.5s;
}
.no-move {
    transition: transform 0s;
}
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}

.list-group-item {
    cursor: move;
}
.list-group-item i {
    cursor: pointer;
}
</style>
