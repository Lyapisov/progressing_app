import {Inject, Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Publication} from "./models/publication";
import {map} from "rxjs/operators";
import {Content} from "./models/content";
import {Author} from "./models/author";
import {Likes} from "./models/likes";

@Injectable({
  providedIn: 'root'
})
export class PublicationsService {

  constructor(
    private httpClient: HttpClient,
    @Inject('apiUrl') private apiUrl: string
  ) {
  }

  public getList(): Observable<Publication[]> {
    const url = `${this.apiUrl}/publications`;

    return this.httpClient.get(url).pipe(
      map((response: any) =>
        response.map(
        (responseItem: any) =>
          new Publication(
            responseItem.id,
            new Content(
              responseItem.content.title,
              responseItem.content.text,
              responseItem.content.imageId,
            ),
            new Author(
              responseItem.author.id,
              responseItem.author.fullName,
              responseItem.author.role,
            ),
            responseItem.status,
            new Likes(
              responseItem.likes.count,
              responseItem.likes.authors,
            ),
            responseItem.createdAt,
          )
        )
      )
    );
  }

  public create(
    title: string,
    text: string,
    imageId: string
  ): Observable<void> {
    const url = `${this.apiUrl}/publications`;

    const requestBody: any = {
      title: title,
      text: text,
      imageId: imageId,
    };

    return this.httpClient.post(url, requestBody).pipe(
      map(() => {
        return;
      })
    );
  }
}
