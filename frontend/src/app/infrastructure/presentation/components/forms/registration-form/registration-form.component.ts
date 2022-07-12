import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators
} from '@angular/forms';
import { RegistrationFormData } from './registration-form-data';

@Component({
  selector: 'app-registration-form',
  templateUrl: './registration-form.component.html',
  styleUrls: ['./registration-form.component.scss']
})
export class RegistrationFormComponent implements OnInit {
  registrationForm: FormGroup;
  @Output() submitEmitter: EventEmitter<RegistrationFormData> = new EventEmitter();

  hidePassword = true;

  displayedSelectedRoles: string[] = [
    'fan',
    'musician',
    'producer',
  ];

  constructor(private formBuilder: FormBuilder) {}

  ngOnInit() {
    this.registrationForm = this.initForm();
  }

  private initForm(): FormGroup {
    return this.formBuilder.group({
      login: [null, [Validators.required]],
      email: [null, [Validators.required, Validators.email]],
      password: [null, [Validators.required]],
      role: [null, [Validators.required]]
    });
  }

  loginControl(): AbstractControl {
    return this.registrationForm.get('login');
  }

  emailControl(): AbstractControl {
    return this.registrationForm.get('email');
  }

  passwordControl(): AbstractControl {
    return this.registrationForm.get('password');
  }

  roleControl(): AbstractControl {
    return this.registrationForm.get('role');
  }

  onSubmit() {
    this.submitEmitter.emit(
      new RegistrationFormData(
        this.loginControl().value,
        this.emailControl().value,
        this.passwordControl().value,
        this.roleControl().value,
      )
    );
  }
}
