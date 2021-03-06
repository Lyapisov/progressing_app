import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import {UserService} from "./user.service";
import {User} from "./user";

@Injectable({
  providedIn: 'root'
})
export class GetMineUserHandlerService {
  constructor(private userService: UserService) {}

  public execute(): Observable<User> {
    return this.userService.getMine();
  }
}
