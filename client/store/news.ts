import { Module, Mutation, VuexModule } from 'vuex-module-decorators';
import Axios from 'Axios';

@Module({
  stateFactory: true,
})
export default class NewsModule extends VuexModule {
  private posts: any[] = [];
  private page = 1;
  private selected!: any;

  @Mutation
  public push(news: any) {
    for (const post of news) {
      this.posts.push(post);
    }
    this.page++;
  }

  @Mutation
  public select(post: any) {
    this.selected = post;
  }
}
