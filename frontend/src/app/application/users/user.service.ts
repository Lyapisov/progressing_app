import {Observable} from 'rxjs';
import { map } from 'rxjs/operators';
import {Inject, Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {User} from "./user";

@Injectable({
  providedIn: 'root'
})

export class UserService {

  constructor(
    private httpClient: HttpClient,
    @Inject('apiUrl') private apiUrl: string
  ) {
  }

  public getMine(): Observable<User> {
    const url = `${this.apiUrl}/users/mine`;

    return this.httpClient.get(url).pipe(
      map((response: { id: string; profileCreated: boolean;}
      ) => {
        return new User(
          response.id,
          response.profileCreated,
        );
      })
    )
  };
}
