import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {BaseComponent} from "../base/base.component";
import {LoginPageComponent} from "./pages/login-page/login-page.component";
import {ProfilePageComponent} from "./pages/profile-page/profile-page.component";
import {LocalStorageRouteGuardService} from "../services/route-guards/local-storage-route-guard.service";
import {RegistrationUserPageComponent} from "./pages/registration/registration-user-page/registration-user-page.component";
import {LogoutPageComponent} from "./pages/logout-page/logout-page.component";


const routes: Routes = [
  {
    path: '',
    redirectTo: 'profile/mine',
    pathMatch: 'full'
  },
  {
    path: '',
    component: BaseComponent,
    children: [
      {
        path: 'login',
        component: LoginPageComponent
      },
      {
        path: 'sign-up',
        component: RegistrationUserPageComponent
      },
      {
        path: 'logout',
        component: LogoutPageComponent,
        canActivate: [LocalStorageRouteGuardService]
      },
      {
        path: 'profile/mine',
        component: ProfilePageComponent,
        canActivate: [LocalStorageRouteGuardService]
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { relativeLinkResolution: 'legacy' })],
  exports: [RouterModule],
})
export class AppRoutingModule {}
