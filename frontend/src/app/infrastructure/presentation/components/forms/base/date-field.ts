import {BaseForm} from "./base-form";

export class DateField extends BaseForm<string> {
  override controlType = 'date';
  override type = 'date';
}
