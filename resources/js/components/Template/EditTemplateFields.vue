<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div v-if="this.propsTemplate[0]['fields'] != []" class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Field Name</th>
                            <th>Data Type</th>
                            <th>Default</th>
                            <th>Is Required</th>
                            <th>Options</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(field, index) in this.propsTemplate[0]['fields']">
                            <td>{{ field['name'] }}</td>
                            <td>{{ field['type'] }}</td>
                            <td>Null</td>
                            <td>{{ field['is_required'] != "" ? field['is_required'] : 0 }}</td>
                            <td>
                                <div v-if="field['options'].length > 0" v-for="name in field['options']" style="display: inline-block">
                                    <button class="ml-1">{{name.label}}</button>
                                </div>
<!--                                <div v-if="field['options'].length < 1">-->
<!--                                    Null-->
<!--                                </div>-->
                            </td>
                            <td>
                                <a v-on:click="editField(index)"><i class="fa fa-edit"></i></a>
                                <a v-on:click="deleteField(index, field['id'])"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <p style="text-align: center">No Template Field available</p>
                </div>
                <div class="float-left mt-3">
                    <button type="button" style="margin-bottom: 15px;" @click="showTemplateField = true" class="btn-primary">Add Field</button>
                </div>
            </div>
            <Modal v-model="showTemplateField" title="Templates Fields" modal-style="max-width: 815px">
                <div class="col-md-12">
                    <div class="card">
    <!--                    <div class="card-header">-->
    <!--                        <h3 class="card-title">Templates Fields</h3>-->
    <!--                    </div>-->
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Template Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="fieldName" name="fieldName"
                                           id="template_field_name" placeholder="Template Field Name">
                                    <p v-if="this.errorFieldName" class="text-danger">{{this.errorFieldName}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Field Type</label>
                                <div class="col-sm-10">
                                    <select v-model="dataType" id="type" class="form-control select2 "
                                            data-placeholder="Select a Type" style="width: 100%;" name="dataType">
                                        <option value="" disabled selected>Select a Data Type</option>
                                        <option :value="option['value']" v-for="(option, index) in field_types">{{ option['label'] }}</option>
                                    </select>
                                    <p v-if="this.errorDataType" class="text-danger">{{this.errorDataType}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="default" class="col-sm-2 col-form-label">Default</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled class="form-control" name="default"
                                           id="default" value="Nullable">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="is_required" class="col-sm-2 col-form-label">Is Required</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" v-model="isRequired" value="" name="idRequired">
                                </div>
                            </div>
                            <div v-if="this.dataType == 'radio' || this.dataType == 'checkbox' || this.dataType == 'select'" class="form-group row">
                                <label for="options" class="col-sm-2 col-form-label">Options</label>
                                <div v-if="this.dataType == 'radio' || this.dataType == 'checkbox' || this.dataType == 'select'"  class="col-md-5
                                    card-body table-responsive p-0 justify-content-center">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Option Name</th>
                                            <th>Option Value</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(option, index) in this.recentlyAddedOptions">
                                            <td>
                                                <input type="text" class="form-control" id="options"
                                                       name="optionsName" v-model="option.label" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="options"
                                                       name="optionsValue" v-model="option.value" required>
                                            </td>
                                            <td><a v-on:click="deleteOption(index)"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" v-model="optionsName" class="form-control" id="options"
                                                       name="optionsName" >
                                            </td>
                                            <td>
                                                <input type="text" v-model="optionsValue" class="form-control" id="options"
                                                       name="optionsValue" >
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="float-right mt-3">
                                        <a v-on:click="addOptions"><button type="button" class="btn-warning">Add Options</button></a>
                                    </div>
                                </div>
                                <div v-if="this.errorOption">
                                    <p class="text-danger">{{this.errorOption}}</p>
                                </div>
                            </div>
                            <div class="float-left" v-if="this.fieldId == 'Null'">
                                <a v-on:click="addField(fieldId)"><button type="button" class="btn-danger">Add Field</button>
                                </a>
                            </div>
                            <div class="float-left" v-else>
                                <a v-on:click="updateField(fieldId)"><button type="button" class="btn-danger">Update Template Field</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2'
import VueModal from '@kouts/vue-modal'
import '@kouts/vue-modal/dist/vue-modal.css'

export default {
    name: "EditTemplateField",
    props: {
        field_types: { type: Array, required: true },
        templates:{ required: true},
        config: { required: true }
    },
    components: {
        'Modal'  : VueModal
    },
    data() {
        return {
            templateFields: [],
            fieldName: '',
            dataType: '',
            isRequired: '',
            options: '',
            errorFieldName: '',
            errorDataType: '',
            errorOptionsName: '',
            errorOptionsValue: '',
            optionsName: '',
            optionsValue: '',
            getFields:[],
            editTemplateField:[],
            editTemplateFieldOption:[],
            templateFieldFlag: false,
            fieldId:'Null',
            latestTemplateFields:'',
            optionId:'Null',
            recentlyAddedOptions: [],
            errorOption: "",
            propsTemplate: [],
            showTemplateField: false,
        }
    },
    watch: {
        fieldName(){
            this.errorFieldName = "";
        },
        dataType(){
            this.errorDataType = "";
            // this.recentlyAddedOptions = [];
        },
        optionsName(){
            this.errorOptionsName = "";
        },
        optionsValue(){
            this.errorOptionsValue = "";
        },
    },
    methods: {
        updateField(id) {
            if (this.dataType == 'email' || this.dataType == 'date' || this.dataType == 'file' || this.dataType == 'number'
                || this.dataType == 'phone' || this.dataType == 'text' || this.dataType == 'textarea'){
                this.recentlyAddedOptions = [];
            }
            if (this.dataType == 'radio' || this.dataType == 'checkbox' || this.dataType == 'select' ){
                if (this.recentlyAddedOptions.length == 0){
                    return this.errorOption = "You choose " + this.dataType + " field type so options are required"
                }
            }
            if (this.fieldName == ""){
                return this.errorFieldName = "Template field name Required"
            }
            if (this.dataType == ""){
                return this.errorDataType = "Data type Required"
            }
            axios.post(this.config.getAdminUserUrl+"/update-template-field",{fieldId: id, field_name : this.fieldName, data_type : this.dataType,
                is_required : this.isRequired, template_id : this.propsTemplate[0].id, default: this.default, options: this.recentlyAddedOptions})
                .then((response) => {
                    this.propsTemplate = response.data.data;
                    this.fieldName = ''
                    this.dataType = ''
                    this.isRequired = ''
                    this.options = ''
                    this.recentlyAddedOptions = [];
                    this.showTemplateField = false
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Template field edited successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
                .catch((error) =>{

                })
        },
        editField(index){
            this.showTemplateField = true;
            this.templateFieldFlag = true;
            this.editTemplateField = "";
            this.optionsName = '';
            this.optionsValue = '';
            this.errorOption = '';
            this.propsTemplate.forEach(i=>{
                this.editTemplateField = i['fields'][index];
                this.fieldId = this.editTemplateField.id;
                this.fieldName = this.editTemplateField.name;
                this.dataType = this.editTemplateField.type;
                this.isRequired = this.editTemplateField.is_required;
                this.default = this.editTemplateField.default;
                this.recentlyAddedOptions = this.editTemplateField.options;
            })
        },
        editOption(index){
            this.editTemplateFieldOption = this.editTemplateField.options[index];
            this.optionId = index;
            this.optionsName = this.editTemplateFieldOption.label;
            this.optionsValue = this.editTemplateFieldOption.value;
        },
        updateOptions(optionId){
            if (this.optionsName == ""){
                return this.errorOptionsName = "Option name id Required"
            }
            if (this.optionsValue == ""){
                return this.errorOptionsValue = "Option value is Required"
            }
            this.editTemplateField.options[optionId].label = this.optionsName;
            this.editTemplateField.options[optionId].value = this.optionsValue;
        },
        deleteField(index, id) {
            axios.post(this.config.getAdminUserUrl+"/delete/"+id)
                .then((response) => {
                    this.propsTemplate[0]['fields'].splice(index, 1);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Template field deleted successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
                .catch((error) =>{

                })
        },
        deleteOption(index) {
            this.recentlyAddedOptions.splice(index, 1);
        },
        addOptions(){
            if (this.optionsName == ""){
                return this.errorOptionsName = "Option name id Required"
            }
            if (this.optionsValue == ""){
                return this.errorOptionsValue = "Option value is Required"
            }
            if (this.optionsName != "" && this.optionsValue != ""){
                this.recentlyAddedOptions.push({'label': this.optionsName, 'value':this.optionsValue});
                this.editTemplateField.options = this.recentlyAddedOptions;
                // clear the input
                this.optionsName = ''
                this.optionsValue = ''
                if (this.recentlyAddedOptions != ""){
                    this.errorOption = ""
                }
            }
        },
        addField() {
            if (this.dataType == 'email' || this.dataType == 'date' || this.dataType == 'file' || this.dataType == 'number'
                || this.dataType == 'phone' || this.dataType == 'text' || this.dataType == 'textarea'){
                this.editTemplateField.options = [];
            }
            if (this.dataType == 'radio' || this.dataType == 'checkbox' || this.dataType == 'select' ){
                if (this.recentlyAddedOptions.length == 0){
                    return this.errorOption = "You choose " + this.dataType + " field type so options are required"
                }
            }
            if (this.fieldName == ""){
                return this.errorFieldName = "Template field name Required"
            }
            if (this.dataType == ""){
                return this.errorDataType = "Data type Required"
            }
            axios.post(this.config.getAdminUserUrl+"/add-template-field",{field_name : this.fieldName, data_type : this.dataType,
                is_required : this.isRequired, template_id : this.propsTemplate[0].id, default: this.default, options: this.recentlyAddedOptions})
                .then((response) => {
                    this.fieldName = ''
                    this.dataType = ''
                    this.isRequired = ''
                    this.options = ''
                    this.recentlyAddedOptions = [];
                    this.optionsName = ''
                    this.optionsValue = ''
                    this.propsTemplate = response.data.data;
                    this.showTemplateField = false
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Template field added successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
                .catch((error) =>{

                })
        },
    },
    mounted() {
        this.propsTemplate = this.templates;
    }
}
</script>
