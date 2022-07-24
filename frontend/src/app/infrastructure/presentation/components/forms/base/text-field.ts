import {BaseForm} from "./base-form";

export class TextField extends BaseForm<string> {
  override controlType = 'textbox';
}
