<template>


    <button @click="open()">↘</button>

    <div class="transition duration-200 transition-opacity" v-show="show_loc">
    <draggable
        class="dragArea ml-5 "
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
            <li class="categories relative ">
                <div class="flex -ml-6 category ">
                    <p class="">{{ element.name }}</p>

                    <AddCategoryForm v-if="$page.props.auth.admin" :category="element" :categories="null"/>
                    <DeleteCategoryForm v-if="$page.props.auth.admin" :category="element"/>
                    <EditCategoryForm v-if="$page.props.auth.admin" :category="element"/>

                </div>
                <div class="ml-5">
                    <TreeChild :show="props.show" :category="element.id" :move="props.move" :categories="element.all_sub_categories"/>
                </div>
            </li>
        </template>
    </draggable>
    </div>
</template>


<script setup>
import {ref, watch} from "vue";
import draggable from 'vuedraggable'
import {useForm} from "@inertiajs/vue3";
import AddCategoryForm from "@/Components/AddCategoryForm.vue";
import EditCategoryForm from "@/Components/EditCategoryForm.vue";
import DeleteCategoryForm from "@/Components/DeleteCategoryForm.vue";


let props = defineProps({
    categories : Object,
    move: Boolean,
    category : Number,
    show: Object,
})


// Visibility
let show_loc = ref(false);

let open = () => {
    show_loc.value = !show_loc.value
}

let changeVisibility = (value) => {
    show_loc.value = value
}

watch(() => props.show.count, (value) =>{
    changeVisibility(props.show.show)
},)



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
    categoriesForm.category_parent = props.category

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

<style scoped>
.dragArea {
    min-height: 50px;
    outline: 1px dashed;
}
.categories::before {
    position: absolute;
    display: block;
    top: -28px;
    left: -25px;
    content: "";
    width: 3px;
    height: 100%;
    background: gray;
}

.category::before {
    position: relative;
    display: flex;
    top: 9px;
    content: "";
    width: 25px;
    height: 3px;
    background: gray;
    left: -1px;
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
