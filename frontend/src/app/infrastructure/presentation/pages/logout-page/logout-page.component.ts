import { Component, OnInit } from '@angular/core';
import { AuthTokenProviderService } from '../../../services/auth-token-provider.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-logout-page',
  templateUrl: './logout-page.component.html',
  styleUrls: ['./logout-page.component.scss']
})
export class LogoutPageComponent implements OnInit {
  constructor(
    private authProvider: AuthTokenProviderService,
    private router: Router
  ) {}

  ngOnInit() {
    this.logout();
  }

  private logout(): void {
      this.authProvider.clearToken();
      this.router.navigate(['/']);
  }
}
