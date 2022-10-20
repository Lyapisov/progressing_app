import {PublicationsService} from "../publications.service";
import {Observable} from "rxjs";
import {Injectable} from "@angular/core";

@Injectable({
  providedIn: 'root'
})
export class CreatePublicationHandlerService {

  constructor(private service: PublicationsService) {}

  public execute(
    title: string,
    text: string,
    imageId: string
  ): Observable<void> {
    return this.service.create(
      title, text, imageId
    );
  }
}
