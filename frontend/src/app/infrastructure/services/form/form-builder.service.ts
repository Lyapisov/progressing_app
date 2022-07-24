import {Injectable} from "@angular/core";
import {BaseForm} from "../../presentation/components/forms/base/base-form";
import {FormControl, FormGroup, Validators} from "@angular/forms";

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
