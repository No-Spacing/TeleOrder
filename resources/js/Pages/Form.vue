<script setup>
import Layout from '../Layout/Main.vue'
import { watch, ref, computed } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import { nullifyTransforms } from 'vuetify/lib/util/animation.mjs';
 
const codeSearch = ref(null);
const loading = ref(false);

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
    net_amount: null,
  }
]);

// watch works directly on a ref
watch(codeSearch, (value) => {
    loading.value = true
    router.get('/', {
        search: value,
    },
    {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false
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
                    loading.value = true
                    router.get('/', { search: searchTerm }, {
                        preserveState: true,
                        preserveScroll: true,
                        only: ['products'],
                        onSuccess: (page) => {
                            fields.value[idx].products = page.props.products;
                            loading.value = false;
                        }
                    });
                }
            );
        });
    },
  { deep: true, immediate: true }
);

watch(
  fields,
  (newFields) => {
    newFields.forEach((item) => {
      if (item.price != null && item.quantity != null) {
        item.net_amount = item.price * item.quantity
      } else {
        item.net_amount = null
      }
    })
  },
  { deep: true }
)
const onProductSelect = (field) => {
    const selected = field.products.find(product => product.id === field.value);
    field.description = selected?.description || '';
    field.uom = selected?.uom || '';
};


function submit(){
    loading.value = true;
    const inputValues = fields.value.map(field => ({
        product_id: field.value,
        quantity: field.quantity,
        price: field.price,
        net_amount: field.net_amount,
    }));

    // router.post('/submit',{
    //     code: form.code,
    //     customer: form.customer,
    //     paymentTerms: form.paymentTerms,
    //     deliveredBy: form.deliveredBy,
    //     deliveredTo: form.deliveredTo,
    //     specialInstruction: form.specialInstruction,
    //     inputs: inputValues
    // })

    axios.post('/submit', {
        code: form.code,
        customer: form.customer,
        paymentTerms: form.paymentTerms,
        deliveredBy: form.deliveredBy,
        deliveredTo: form.deliveredTo,
        specialInstruction: form.specialInstruction,
        inputs: inputValues
    }, {
        responseType: 'blob',
    })
    .then((response) => {
        const fileURL = window.URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
        window.open(fileURL); // Opens in a new tab
        loading.value = false;
    })
    .catch((error) => {
        console.error('PDF generation failed:', error);
        loading.value = false;
    });
}

</script>
<template>
    <Layout>
        <v-container fluid>
            <form @submit.prevent="submit">
                <v-card title="Delivery Details" variant="outlined" class="ma-2 pa-2">
                    <v-card-text>
                        <v-row no-gutters>
                            <v-col md="6" cols="12">
                                <v-autocomplete
                                    v-model:search="codeSearch"
                                    class="mx-2"
                                    v-model="form.code"
                                    label="Code"
                                    :items="props.codes"
                                    item-title="code"
                                    item-value="id"
                                    @update:model-value="update"
                                    
                                ></v-autocomplete>
                            </v-col>
                            <v-col md="6" cols="12">
                                <v-autocomplete
                                    label="Customer"
                                    class="mx-2"
                                    v-model="form.customer"
                                    :items="props.codes[0]?.customers"
                                    item-title="customer"
                                    item-value="id"
                                    
                                ></v-autocomplete>
                            </v-col>
                            <v-col md="4" cols="12">
                                <v-select
                                    label="Payment Terms"
                                    class="mx-2"
                                    v-model="form.paymentTerms"
                                    :items="['CASH', 'PDC', 'CHARGE']"
                                    
                                ></v-select>
                            </v-col>
                            <v-col md="4" cols="12">
                                <v-select
                                    label="Delivered By"
                                    class="mx-2"
                                    v-model="form.deliveredBy"
                                    :items="['AIR', 'SEA', 'TRUCK']"
                                    
                                ></v-select>
                            </v-col>
                            <v-col md="4" cols="12">
                                <v-text-field
                                    class="mx-2"
                                    label="Delivered To"
                                    v-model="form.deliveredTo"
                                    
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea 
                                    class="mx-2"
                                    label="Special Instruction"
                                    v-model="form.specialInstruction"
                                    rows="3"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <v-card title="Product Details" variant="outlined" class="ma-2 pa-2">
                    <v-card-text>
                        <v-row no-gutters v-for="(field, index) in fields" :key="index">
                            <v-col cols="12" md="2" class="mx-2"> 
                                <v-autocomplete
                                    label="Product Code"
                                    v-model="field.value"
                                    v-model:search="field.search"
                                    :items="field.products"
                                    item-title="code"
                                    item-value="id"
                                    @update:modelValue="onProductSelect(field)"
                                    
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
                                    
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="2" class="mx-2"> 
                                <v-text-field 
                                    placeholder="Unit Price PHP - Philippine Peso"
                                    v-model="field.price"
                                    type="number"
                                    
                                ></v-text-field>
                            </v-col>
                             <v-col cols="12" md="2" class="mx-2"> 
                                <v-text-field 
                                    placeholder="Net Amount"
                                    v-model="field.net_amount"
                                    type="number"
                                    readonly
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="3" class="mx-2 mb-6">
                                <v-btn class="mr-4" @click="addField" :ripple="false" elevation="2">Add Input</v-btn>
                                <v-btn v-if="index >= 1" @click="removeField(index)" :ripple="false" elevation="2">Remove</v-btn>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <div class="d-flex justify-center">
                    <v-btn
                        type="submit"
                        size="large"
                        :width="600"
                        :loading="loading"
                    >
                        submit
                    </v-btn>
                </div>
            </form>
        </v-container>
    </Layout>
</template>