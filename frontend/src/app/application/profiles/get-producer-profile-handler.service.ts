import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import {ProfilesService} from "./profiles.service";
import {Profile} from "./profile";

@Injectable({
  providedIn: 'root'
})
export class GetProducerProfileHandlerService {
  constructor(private profileService: ProfilesService) {}

  public execute(id: string): Observable<Profile> {
    return this.profileService.getProducerProfile(id);
  }
}
