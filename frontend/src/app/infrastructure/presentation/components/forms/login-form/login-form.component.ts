import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators
} from '@angular/forms';
import { LoginFormData } from './login-form-data';

@Component({
  selector: 'app-login-form',
  templateUrl: './login-form.component.html',
  styleUrls: ['./login-form.component.scss']
})
export class LoginFormComponent implements OnInit {
  loginForm: FormGroup;
  @Output() submitEmitter: EventEmitter<LoginFormData> = new EventEmitter();

  constructor(private fb: FormBuilder) {}

  ngOnInit() {
    this.loginForm = this.initForm();
  }

  private initForm(): FormGroup {
    return this.fb.group({
      login: [null, [Validators.required]],
      password: [null, [Validators.required]]
    });
  }

  loginControl(): AbstractControl {
    return this.loginForm.get('login');
  }

  passwordControl(): AbstractControl {
    return this.loginForm.get('password');
  }

  onSubmit() {
    this.submitEmitter.emit(
      new LoginFormData(this.loginControl().value, this.passwordControl().value)
    );
  }
}
