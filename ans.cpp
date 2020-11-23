#include <bits/stdc++.h>

using namespace std;

int main()
{
  string s="abd";
  auto it=s.begin();
  while(it!=s.end())
  {
      if((it+1)!=s.end())
      {
          int a=*it,b=*(it+1);
          string ans=to_string(b-a);
         
        
          s.insert(it+1,ans);
          it++;
          it++;
      }
      else
      {
          break;
      }
  }
  cout<<s;

    return 0;
}

