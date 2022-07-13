import { Injectable } from '@angular/core';
import {RegistrationService} from "./registration.service";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class RegistrationHandlerService {
  constructor(private registrationService: RegistrationService) {}

  public execute(
    loginValue: string,
    emailValue: string,
    passwordValue: string,
  ): Observable<void> {
    return this.registrationService
      .signUp(
        loginValue,
        emailValue,
        passwordValue,
      );
  }
}
