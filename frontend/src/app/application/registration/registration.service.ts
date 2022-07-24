import {Inject, Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {map} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})

export class RegistrationService {

  constructor(
    private httpClient: HttpClient,
    @Inject('apiUrl') private apiUrl: string
  ) {
  }

  public signUp(
    loginValue: string,
    emailValue: string,
    passwordValue: string,
  ): Observable<void> {
    const url = `${this.apiUrl}/sign-up`;

    const requestBody: any = {
      login: loginValue,
      email: emailValue,
      password: passwordValue,
    };

    return this.httpClient.post(url, requestBody).pipe(
      map((response) => {
        return;
      })
    );
  };

  public createFan(
    firstName: string,
    lastName: string,
    fatherName: string,
    birthday: Date,
    address: string,
    phone: string,
  ): Observable<void> {
    const url = `${this.apiUrl}/profiles/fans`;

    const requestBody: any = {
      firstName: firstName,
      lastName: lastName,
      fatherName: fatherName,
      birthday: birthday,
      address: address,
      phone: phone,
    };

    return this.httpClient.post(url, requestBody).pipe(
      map((response) => {
        return;
      })
    );
  }

  public createMusician(
    firstName: string,
    lastName: string,
    fatherName: string,
    birthday: Date,
    address: string,
    phone: string,
  ): Observable<void> {
    const url = `${this.apiUrl}/profiles/musicians`;

    const requestBody: any = {
      firstName: firstName,
      lastName: lastName,
      fatherName: fatherName,
      birthday: birthday,
      address: address,
      phone: phone,
    };

    return this.httpClient.post(url, requestBody).pipe(
      map((response) => {
        return;
      })
    );
  }

  public createProducer(
    firstName: string,
    lastName: string,
    fatherName: string,
    birthday: Date,
    address: string,
    phone: string,
  ): Observable<void> {
    const url = `${this.apiUrl}/profiles/producers`;

    const requestBody: any = {
      firstName: firstName,
      lastName: lastName,
      fatherName: fatherName,
      birthday: birthday,
      address: address,
      phone: phone,
    };

    return this.httpClient.post(url, requestBody).pipe(
      map((response) => {
        return;
      })
    );
  }
}
