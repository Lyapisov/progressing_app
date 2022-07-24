import {BaseForm} from "../../base/base-form";
import {TextField} from "../../base/text-field";
import {DateField} from "../../base/date-field";
import {Injectable} from "@angular/core";

@Injectable({
  providedIn: 'root'
})
export class BaseProfileForm {
  public readonly fields: BaseForm<string>[]

  constructor() {
    this.fields = [
      new TextField({
        key: 'firstName',
        label: 'First name',
        required: true,
        order: 1
      }),
      new TextField({
        key: 'lastName',
        label: 'Last name',
        required: false,
        order: 2
      }),
      new TextField({
        key: 'fatherName',
        label: 'Father name',
        required: false,
        order: 3
      }),
      new DateField({
        key: 'birthday',
        label: 'Birthday',
        required: true,
        order: 4
      }),
      new TextField({
        key: 'phone',
        label: 'Phone number',
        required: false,
        order: 5
      }),
      new TextField({
        key: 'address',
        label: 'Address',
        required: false,
        order: 6
      }),
    ]
  }
}
