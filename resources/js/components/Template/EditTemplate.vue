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
<!--                    <input class="form-check-input" type="radio" v-model="insertion_name" value="single">-->
<!--                    <label class="form-check-label">Single</label>-->
<!--                </div>-->
<!--                <div class="form-check">-->
<!--                    <input class="form-check-input" type="radio" v-model="insertion_name" value="multiple">-->
<!--                    <label class="form-check-label">Multiple</label>-->
<!--                </div>-->
<!--                <p v-if="this.errorInsertionType" class="text-danger">{{this.errorInsertionType}}</p>-->
<!--            </div>-->
<!--        </div>-->
        <edit-template-fields :templates="this.templates" :field_types="this.field_types"
                              :config="this.config">
        </edit-template-fields>
        <div class="card-footer">
            <button type="button" @click="updateTemplates" class="btn btn-info">Update Template</button>
            <button type="button" class="btn btn-default float-right">Cancel</button>
        </div>
    </div>
</template>

<script>
import EditTemplateFields from './EditTemplateFields.vue';
import axios from "axios";
import Swal from 'sweetalert2'

export default {
    name: "EditTemplate",
    data() {
        return {
            templateFields: [],
            template_name: '',
            insertion_name: '',
            errorTemplateName: '',
            errorInsertionType: '',
            templateId: '',
            editedTemplates: [],
        }
    },

    props: {
        field_types: { type: Array, required: true },
        templates: { required: true},
        config: { required: true }
    },
    components: {
        'edit-template-fields'  : EditTemplateFields
    },
    watch: {
        template_name(){
            this.errorTemplateName = "";
        },
        insertion_name(){
            this.errorInsertionType = "";
        },
    },
    methods:{
        updateTemplates(){
            if (this.template_name == ""){
                return this.errorTemplateName = 'Template Name Required';
            }
            // if (this.insertion_name == ""){
            //     return this.errorInsertionType = 'Choose insertion Type Required';
            // }

            axios.post(this.config.getAdminUserUrl+"/update",{templateId : this.templateId, template_name : this.template_name})
                .then((response) => {
                    this.editedTemplates = response.data.data;
                    this.fetchTemplates();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Template edited successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
                .catch((error) =>{

                })
        },
        fetchTemplates(){
            this.editedTemplates.forEach(i=>{
                this.templateId = i.id;
                this.template_name = i.name;
                this.insertion_name = i.insertion_type;
            })
        },
    },
    mounted() {
        this.editedTemplates = this.templates;
        this.fetchTemplates();
    }
}
</script>
