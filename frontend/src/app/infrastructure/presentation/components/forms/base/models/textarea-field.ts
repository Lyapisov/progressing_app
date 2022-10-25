import {BaseForm} from "./base-form";

export class TextareaField extends BaseForm<string> {
    override controlType = 'textarea';
}
