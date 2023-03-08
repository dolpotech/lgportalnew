<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div v-show="templateFields.length > 0" class="card-body table-responsive p-0 mb-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Field</th>
                            <th>Data Type</th>
                            <th>Default</th>
                            <th>Is Required</th>
                            <th>Options</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(field, index) in templateFields">
                            <td>{{ field['name'] }}</td>
                            <td>{{ field['type'] }}</td>
                            <td>Null</td>
                            <td>{{ field['is_required'] != "" ? field['is_required'] : false }}</td>
                            <td>
                                <div v-if="field['options'].length > 0" v-for="name in field['options']" style="display: inline-block">
                                    <button class="ml-1">{{name.label}}</button>
                                </div>
                                <div v-if="field['options'].length == 0">
                                    <p>Null</p>
                                </div>
                            </td>
                            <td><a v-on:click="deleteField(index)"><i class="fa fa-trash"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary float-left" style="margin-bottom: 15px;" @click="showTemplateField = true">Add Field</button>
            </div>
            <Modal v-model="showTemplateField" title="Templates Fields" modal-style="max-width: 815px">
                <div class="col-md-12">
                    <div class="card">
<!--                        <div class="card-header">-->
<!--                            <h3 class="card-title">Templates Fields</h3>-->
<!--                        </div>-->
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
                                <div class="col-md-5 card-body table-responsive p-0 justify-content-center">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Option Name</th>
                                            <th>Option Value</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(option, index) in options">
                                            <td>
                                                <input type="text" class="form-control" id="options"
                                                       name="optionsName" v-model="option['label']" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="options"
                                                       name="optionsValue" v-model="option['value']" required>
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
                                    <div class="float-left mt-3">
                                        <a v-on:click="addOptions"><button type="button" class="btn-warning">Add Options</button></a>
                                    </div>
                                </div>

                                <div v-if="this.errorOption">
                                    <p class="text-danger">{{this.errorOption}}</p>
                                </div>
                            </div>
                        </div>
                        <a v-on:click="addField"><button type="button" class="btn btn-primary float-right" >Save</button></a>
<!--                        <a><button type="button" class="btn btn-secondary float-right" @click="showTemplateField = false" >Close</button></a>-->
                    </div>
                </div>
            </Modal>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
import VueModal from '@kouts/vue-modal'
import '@kouts/vue-modal/dist/vue-modal.css'

export default {
    name: "TemplateField",
    props: {
        field_types: { type: Array, required: true },
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
            options: [],
            errorFieldName: '',
            errorDataType: '',
            errorOptionsName: '',
            errorOptionsValue: '',
            optionsName: '',
            optionsValue: '',
            errorOption: '',
            showTemplateField: false,
        }
    },
    watch: {
        fieldName(){
            this.errorFieldName = "";
        },
        dataType(){
            this.errorDataType = "";
            this.options = [];
        },
        optionsName(){
            this.errorOptionsName = "";
        },
        optionsValue(){
            this.errorOptionsValue = "";
        },
    },
    methods: {
        addField() {
            if (this.dataType == 'email' || this.dataType == 'date' || this.dataType == 'file' || this.dataType == 'number'
                || this.dataType == 'phone' || this.dataType == 'text' || this.dataType == 'textarea'){
                this.options = '';
            }
            if (this.dataType == 'radio' || this.dataType == 'checkbox' || this.dataType == 'select' ){
                if (this.options.length == 0){
                    return this.errorOption = "You choose " + this.dataType + " field type so options are required"
                }
            }
            if (this.fieldName == ""){
                return this.errorFieldName = "Template field name Required"
            }
            if (this.dataType == ""){
                return this.errorDataType = "Data type Required"
            }
            if (this.fieldName != "" && this.dataType != ""){
                this.templateFields.push({'name':this.fieldName, 'type':this.dataType, 'is_required':this.isRequired,
                    'options':this.options})
                // clear the input
                this.fieldName = ''
                this.dataType = ''
                this.isRequired = ''
                this.options = ''
                this.showTemplateField = false
            }
            this.onchangeFields();
        },
        onchangeFields () {
            this.$emit('templateField', this.templateFields)
        },
        addOptions(){
            if (this.optionsName == ""){
                return this.errorOptionsName = "Option name id Required"
            }
            if (this.optionsValue == ""){
                return this.errorOptionsValue = "Option value is Required"
            }
            if (this.optionsName != "" && this.optionsValue != ""){
                this.options.push({'label': this.optionsName, 'value':this.optionsValue})
                // clear the input
                this.optionsName = ''
                this.optionsValue = ''
                this.errorOption = ''
            }
        },
        deleteField(index) {
            this.templateFields.splice(this.templateFields.indexOf(index), 1);
        },
        deleteOption(index) {
            this.options.splice(index, 1);
            // this.options.splice(this.options.indexOf(index), 1);
        }
    },
    mounted() {

    }
}
</script>
