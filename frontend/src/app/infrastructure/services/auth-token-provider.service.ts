import { Injectable } from '@angular/core';
import {AuthToken} from "../../application/login/auth-token";

@Injectable({
  providedIn: 'root'
})
export abstract class AuthTokenProviderService {

  abstract setToken(authToken: AuthToken): void;

  abstract clearToken(): void;

  abstract getToken(): string|null;
}

