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
    roleValue: string
  ): Observable<void> {
    const url = `${this.apiUrl}/sign-up`;

    const requestBody: any = {
      login: loginValue,
      email: emailValue,
      password: passwordValue,
      role: roleValue,
    };

    return this.httpClient.post(url, requestBody).pipe(
      map((response) => {
        console.log(response)
        return;
      })
    );
  };
}
