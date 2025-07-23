<script setup>
import Layout from '../Layout/Main.vue'
import { watch, ref, computed } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import { nullifyTransforms } from 'vuetify/lib/util/animation.mjs';
 
const codeSearch = ref(null);

const props = defineProps({ 
    codes: Object,
    products: Object
})

const form = useForm({
    code: null,
    customer: null,
    paymentTerms: null,
    deliveredBy: null,
    deliveredTo: null,
    specialInstruction: null,
})

const fields = ref([
  {
    value: '',
    search: '',
    products: [],
    description: '',
    uom: '',
    quantity: null,
    price: null,
    netPrice: null,
  }
]);

// watch works directly on a ref
watch(codeSearch, (value) => {
    router.get('/', {
        search: value,
    },
    {
        preserveState: true,
        onSuccess: () => {
        }
    });
})

function update(){
    form.reset('customer')
}

const addField = () => {
    fields.value.push({ value: '' });
};

const removeField = (index) => {
    fields.value.splice(index, 1);
};

watch(
    fields,
    (newFields) => {
        newFields.forEach((field, idx) => {
            watch(
                () => field.search,
                (searchTerm) => {
                    router.get('/', { search: searchTerm }, {
                        preserveState: true,
                        only: ['products'],
                        onSuccess: (page) => {
                            fields.value[idx].products = page.props.products;
                        }
                    });
                }
            );
        });
    },
  { deep: true, immediate: true }
);

const onProductSelect = (field) => {
    const selected = field.products.find(product => product.id === field.value);
    field.description = selected?.description || '';
    field.uom = selected?.uom || '';
};


function submit(){
    const inputValues = fields.value.map(field => ({
        product_id: field.value,
        quantity: field.quantity,
        price: field.price,
        netPrice: field.netPrice,
    }));

    router.post('/submit',{
        code: form.code,
        customer: form.customer,
        paymentTerms: form.paymentTerms,
        deliveredBy: form.deliveredBy,
        deliveredTo: form.deliveredTo,
        specialInstruction: form.specialInstruction,
        inputs: inputValues
    })
}

</script>
<template>
    <Layout>
        <v-container fluid>
            <form @submit.prevent="submit">
                <v-row no-gutters>
                    <v-col cols="12">
                        <v-autocomplete
                            v-model:search="codeSearch"
                            v-model="form.code"
                            label="Code"
                            :items="props.codes"
                            item-title="code"
                            item-value="id"
                            @update:model-value="update"
                            required
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            label="Payment Terms"
                            v-model="form.paymentTerms"
                            :items="['CASH', 'PDC', 'CHARGE']"
                            required
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            label="Delivered By"
                            v-model="form.deliveredBy"
                            :items="['AIR', 'SEA', 'TRUCK']"
                            required
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-autocomplete
                            label="Customer"
                            v-model="form.customer"
                            :items="props.codes[0]?.customers"
                            item-title="customer"
                            item-value="id"
                            required
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="Delivered To"
                            v-model="form.deliveredTo"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea 
                            label="Special Instruction"
                            v-model="form.specialInstruction"
                            required
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-card title="Product" variant="outlined">
                    <v-card-text>
                        <v-row no-gutters v-for="(field, index) in fields" :key="index">
                            <v-col cols="12" md="2"> 
                                <v-autocomplete
                                    label="Product Code"
                                    v-model="field.value"
                                    v-model:search="field.search"
                                    :items="field.products"
                                    item-title="code"
                                    item-value="id"
                                    @update:modelValue="onProductSelect(field)"
                                    required
                                ></v-autocomplete>
                            </v-col>   
                            <v-col cols="12" md="3" class="mx-2"> 
                                <v-text-field 
                                    v-model="field.description" 
                                    placeholder="Description"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="1" class="mx-2"> 
                                <v-text-field 
                                    v-model="field.uom" 
                                    placeholder="UOM"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="1" class="mx-2"> 
                                <v-text-field 
                                    placeholder="Quantity"
                                    v-model="field.quantity"
                                    type="number"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="2" class="mx-2"> 
                                <v-text-field 
                                    placeholder="Unit Price PHP - Philippine Peso"
                                    v-model="field.price"
                                    type="number"
                                    required
                                ></v-text-field>
                            </v-col>
                             <v-col cols="12" md="2" class="mx-2"> 
                                <v-text-field 
                                    placeholder="Net Amount"
                                    v-model="field.netPrice"
                                    type="number"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="3" class="mb-5">
                                <v-btn class="mr-4" @click="addField" :ripple="false" elevation="2">Add Input</v-btn>
                                <v-btn v-if="index >= 1" @click="removeField(index)" :ripple="false" elevation="2">Remove</v-btn>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                <v-btn
                    class="me-4"
                    type="submit"
                >
                    submit
                </v-btn>
            </form>
        </v-container>
    </Layout>
</template>