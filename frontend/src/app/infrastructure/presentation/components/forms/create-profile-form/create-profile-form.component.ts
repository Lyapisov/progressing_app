import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators
} from '@angular/forms';
import { CreateProfileFormData } from './create-profile-form-data';

@Component({
  selector: 'app-create-profile-form',
  templateUrl: './create-profile-form.component.html',
  styleUrls: ['./create-profile-form.component.scss']
})
export class CreateProfileFormComponent implements OnInit {
  createdForm: FormGroup;
  @Output() submitEmitter: EventEmitter<CreateProfileFormData> = new EventEmitter();

  constructor(private formBuilder: FormBuilder) {}

  ngOnInit() {
    this.createdForm = this.initForm();
  }

  private initForm(): FormGroup {
    return this.formBuilder.group({
      firstName: [null, [Validators.required]],
      lastName: [null],
      fatherName: [null],
      birthday: [null, [Validators.required]],
      phone: [null],
      address: [null],
    });
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
