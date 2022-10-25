import {PublicationsService} from "../publications.service";
import {Observable} from "rxjs";
import {Injectable} from "@angular/core";

@Injectable({
  providedIn: 'root'
})
export class LikePublicationHandlerService {

  constructor(private service: PublicationsService) {}

  public execute(
    publicationId: string,
  ): Observable<void> {
    return this.service.like(publicationId);
  }
}
