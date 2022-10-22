import {PublicationsService} from "../publications.service";
import {Observable} from "rxjs";
import {Publication} from "../models/publication";
import {Injectable} from "@angular/core";

@Injectable({
  providedIn: 'root'
})
export class GetPublicationsListHandlerService {

  constructor(private service: PublicationsService) {}

  public execute(): Observable<Publication[]> {
    return this.service.getList();
  }
}
