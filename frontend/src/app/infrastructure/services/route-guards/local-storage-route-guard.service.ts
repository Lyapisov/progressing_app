import { Injectable } from '@angular/core';
import {
  ActivatedRouteSnapshot,
  CanActivate,
  Router,
  RouterStateSnapshot,
  UrlTree
} from '@angular/router';
import { Observable } from 'rxjs';
import { AuthTokenProviderService } from '../auth-token-provider.service';

@Injectable({
  providedIn: 'root'
})
export class LocalStorageRouteGuardService implements CanActivate {
  constructor(
    private authTokenProvider: AuthTokenProviderService,
    private router: Router,
  ) {}

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ):
    | Observable<boolean | UrlTree>
    | Promise<boolean | UrlTree>
    | boolean
    | UrlTree {

    if (!this.authTokenProvider.getToken()) {
      this.router.navigate(['login']);
      return false;
    }

    return true;
  }
}
