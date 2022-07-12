import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import {ProfileService} from "./profile.service";
import {Profile} from "./profile";

@Injectable({
  providedIn: 'root'
})
export class GetMineProfileHandlerService {
  constructor(private profileService: ProfileService) {}

  public execute(): Observable<Profile> {
    return this.profileService.getMine();
  }
}
