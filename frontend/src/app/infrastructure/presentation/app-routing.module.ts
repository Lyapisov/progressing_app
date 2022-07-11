import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {BaseComponent} from "../base/base.component";
import {LoginPageComponent} from "./pages/login-page/login-page.component";


const routes: Routes = [
  {
    path: '',
    component: BaseComponent,
    // children: [
      // {
      //   path: 'deals',
      //   component: DealsPageComponent,
        // canActivate: [LocalStorageRouteGuardService]
      // },
    // ],
  },
  {
    path: 'login',
    component: LoginPageComponent
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { relativeLinkResolution: 'legacy' })],
  exports: [RouterModule],
})
export class AppRoutingModule {}
