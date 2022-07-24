import {BaseForm} from "../../base/base-form";
import {Component, Input} from "@angular/core";
import {FormGroup} from "@angular/forms";

@Component({
  selector: 'app-profile-form',
  templateUrl: './profile-form.component.html',
  styleUrls: ['./profile-form.component.scss']
})
export class ProfileFormComponent {
  @Input() field!: BaseForm<string>;
  @Input() form!: FormGroup;

  get isValid() { return this.form.controls[this.field.key].valid; }
}
