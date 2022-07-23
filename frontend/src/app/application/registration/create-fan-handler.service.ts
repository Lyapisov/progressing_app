import { Injectable } from '@angular/core';
import {RegistrationService} from "./registration.service";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class CreateFanHandlerService {
  constructor(private registrationService: RegistrationService) {}

  public execute(
    firstName: string,
    lastName: string,
    fatherName: string,
    birthday: Date,
    address: string,
    phone: string,
  ): Observable<void> {
    return this.registrationService
      .createFan(
        firstName,
        lastName,
        fatherName,
        birthday,
        address,
        phone,
      );
  }
}
