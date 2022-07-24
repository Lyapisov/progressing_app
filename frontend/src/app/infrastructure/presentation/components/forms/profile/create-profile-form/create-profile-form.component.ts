import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import {
  AbstractControl,
  FormGroup,
} from '@angular/forms';
import { CreateProfileFormData } from './create-profile-form-data';
import {FormBuilderService} from "../../../../../services/form/form-builder.service";
import {BaseForm} from "../../base/models/base-form";
import {ProfileFormBuilder} from "../../base/models/builders/profile-form-builder";

@Component({
  selector: 'app-create-profile-form',
  templateUrl: './create-profile-form.component.html',
  styleUrls: ['./create-profile-form.component.scss']
})
export class CreateProfileFormComponent implements OnInit {
  createdForm!: FormGroup;
  fields: BaseForm<string>[]|null = [];

  @Output() submitEmitter: EventEmitter<CreateProfileFormData> = new EventEmitter();

  constructor(
    private formBuilder: FormBuilderService,
  ) {}

  ngOnInit() {
    this.createdForm = this.initForm();
  }

  private initForm(): FormGroup {
    this.fields = ProfileFormBuilder.createDefault();
    return this.formBuilder.toFormGroup(this.fields)
  }

  firstNameControl(): AbstractControl {
    return this.createdForm.get('firstName');
  }

  lastNameControl(): AbstractControl {
    return this.createdForm.get('lastName');
  }

  fatherNameControl(): AbstractControl {
    return this.createdForm.get('fatherName');
  }

  birthdayControl(): AbstractControl {
    return this.createdForm.get('birthday');
  }

  phoneControl(): AbstractControl {
    return this.createdForm.get('phone');
  }

  addressControl(): AbstractControl {
    return this.createdForm.get('address');
  }

  onSubmit() {
    this.submitEmitter.emit(
      new CreateProfileFormData(
        this.firstNameControl().value,
        this.lastNameControl().value,
        this.fatherNameControl().value,
        this.birthdayControl().value,
        this.addressControl().value,
        this.phoneControl().value,
      )
    );
  }
}
