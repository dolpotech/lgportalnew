<div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label">Template Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="name" id="name" placeholder="Template Name"
               value="{{isset($template->name) ? $template->name : ''}}">
    </div>
</div>
<div class="form-group row">
    <label for="insertion_type" class="col-sm-2 col-form-label">Insertion Type</label>
    <div class="col-sm-10">
        <div class="form-check mr-2">
            <input class="form-check-input" type="radio" name="insertion_type" value="single"
                   @if(isset($template)) @if($template->insertion_type == 'single') checked @endif @endif>
            <label class="form-check-label">Single</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="insertion_type" value="multiple"
                   @if(isset($template)) @if($template->insertion_type == 'multiple') checked @endif @endif>
            <label class="form-check-label">Multiple</label>
        </div>
    </div>
</div>
<section class="content" id="app">
    <template-fields :field_types="{{ json_encode(getTemplateFieldsForVueJs()) }}"
    ></template-fields>
</section>
