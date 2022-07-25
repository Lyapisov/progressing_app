import {Injectable} from "@angular/core";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {BaseForm} from "../../presentation/components/forms/base/models/base-form";

@Injectable({
  providedIn: 'root'
})
export class FormBuilderService {
  constructor() {}

  public toFormGroup(fields: BaseForm<string>[]): FormGroup {
    const group: any = {};

    fields.forEach(field => {
      group[field.key] =
        field.required ?
        new FormControl(field.value || '', Validators.required) :
        new FormControl(field.value || '');
    });

    return new FormGroup(group);
  }
}
