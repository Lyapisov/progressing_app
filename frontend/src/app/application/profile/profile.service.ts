import {Observable} from 'rxjs';
import { map } from 'rxjs/operators';
import {Inject, Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Profile} from "./profile";

@Injectable({
  providedIn: 'root'
})

export class ProfileService {

  constructor(
    private httpClient: HttpClient,
    @Inject('apiUrl') private apiUrl: string
  ) {
  }

  public getMine(): Observable<Profile> {
    const url = `${this.apiUrl}/profile`;

    return this.httpClient.get(url).pipe(
      map((response: { id: string; }
      ) => {
        return new Profile(
          response.id,
        );
      })
    )
  };
}
