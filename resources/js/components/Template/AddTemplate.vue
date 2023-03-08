<template>
    <div>
        <div class="form-group row">
            <label for="template_name" class="col-sm-2 col-form-label">Template Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" v-model="template_name"  placeholder="Template Name">
                <p v-if="this.errorTemplateName" class="text-danger">{{this.errorTemplateName}}</p>
            </div>
        </div>
<!--        <div class="form-group row">-->
<!--            <label for="insertion_type" class="col-sm-2 col-form-label">Insertion Type</label>-->
<!--            <div class="col-sm-10">-->
<!--                <div class="form-check mr-2">-->
<!--                    <input class="form-check-input" type="radio" v-model="insertion_type" value="single">-->
<!--                    <label class="form-check-label">Single</label>-->
<!--                </div>-->
<!--                <div class="form-check">-->
<!--                    <input class="form-check-input" type="radio" v-model="insertion_type" value="multiple">-->
<!--                    <label class="form-check-label">Multiple</label>-->
<!--                </div>-->
<!--                <p v-if="this.errorInsertionType" class="text-danger">{{this.errorInsertionType}}</p>-->
<!--            </div>-->
<!--        </div>-->
        <add-template-fields :field_types="this.field_types" @templateField="onTemplateField"></add-template-fields>
        <div class="card-footer">
            <button type="button" @click="storeTemplates" class="btn btn-info">Add All</button>
            <button type="button" class="btn btn-default float-right">Cancel</button>
        </div>
    </div>
</template>

<script>
import AddTemplateFields from './AddTemplateFields.vue';
import axios from "axios";
import Swal from 'sweetalert2'

export default {
    name: "AddTemplate",
    data() {
        return {
            templateFields: [],
            template_name: '',
            insertion_type: '',
            errorTemplateName: '',
            errorInsertionType: '',
        }
    },

    props: {
        field_types: { type: Array, required: true },
        config: { required: true }
    },
    components: {
        'add-template-fields'  : AddTemplateFields
    },
    watch: {
        template_name(){
            this.errorTemplateName = "";
        },
        insertion_type(){
            this.errorInsertionType = "";
        },
    },
    methods:{
        storeTemplates(){
            if (this.template_name == ""){
               return this.errorTemplateName = 'Template Name Required';
            }

            axios.post(this.config.getAdminUserUrl+ "/store",{template_name : this.template_name,
                template_fields : this.templateFields})
                .then((response) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Template added successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.template_name = ''
                })
                .catch((error) =>{

                })
        },
        onTemplateField (value) {
            this.templateFields = value;
        },
    },
}
</script>
