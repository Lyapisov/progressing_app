import {Component, Input} from "@angular/core";
import {FormGroup} from "@angular/forms";
import {BaseForm} from "../models/base-form";

@Component({
  selector: 'app-base-form',
  templateUrl: './base-form.component.html',
  styleUrls: ['./base-form.component.scss']
})
export class BaseFormComponent {
  @Input() field!: BaseForm<string>;
  @Input() form!: FormGroup;

  get isValid() { return this.form.controls[this.field.key].valid; }
}
