import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class AppModule extends VuexModule {
  private isReady = false;

  @Mutation
  public ready() {
    this.isReady = true;
  }
}
