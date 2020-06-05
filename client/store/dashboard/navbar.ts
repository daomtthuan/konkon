import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class DashboardNavbarModule extends VuexModule {
  private breadcrumb = [];

  @Mutation
  public setBreadcrumb(breadcrumb: any) {
    this.breadcrumb = breadcrumb;
  }
}
