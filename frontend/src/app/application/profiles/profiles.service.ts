import {Observable} from 'rxjs';
import { map } from 'rxjs/operators';
import {Inject, Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Profile} from "./profile";
import {PersonalData} from "./personal-data";

@Injectable({
  providedIn: 'root'
})

export class ProfilesService {

  constructor(
    private httpClient: HttpClient,
    @Inject('apiUrl') private apiUrl: string
  ) {
  }

  public getFanProfile(id: string): Observable<Profile> {
    const url = `${this.apiUrl}/profiles/fans/` + id;

    return this.httpClient.get(url).pipe(
      map((response: {
        id: string;
        personalData: any;
      }
      ) => {
        return new Profile(
          response.id,
          new PersonalData(
            response.personalData.name.first,
            response.personalData.name.last,
            response.personalData.name.father,
            response.personalData.phone.number,
            response.personalData.address,
            response.personalData.birthday,
          )
        );
      })
    )
  };
}
